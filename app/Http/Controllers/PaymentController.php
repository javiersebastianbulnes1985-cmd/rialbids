<?php
namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Checkout\Session;
use Stripe\Transfer;

class PaymentController extends \Illuminate\Routing\Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function checkout($auctionId)
    {
        $auction = Auction::findOrFail($auctionId);
        if (auth()->id() !== $auction->winner_id) abort(403);

        $finalPrice  = $auction->current_price;
        $commission  = $auction->free_commission ? 0 : round($finalPrice * 0.09 + 3, 2);
        $totalAmount = round($finalPrice + $commission, 2);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency'     => 'eur',
                    'unit_amount'  => intval($totalAmount * 100),
                    'product_data' => [
                        'name'        => $auction->title,
                        'description' => 'Precio: €' . number_format($finalPrice, 2) . ' + Comisión: €' . number_format($commission, 2),
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode'        => 'payment',
            'success_url' => route('payment.success', $auction->id),
            'cancel_url'  => route('auctions.show', $auction->id),
            'metadata'    => [
                'auction_id' => $auction->id,
                'buyer_id'   => auth()->id(),
            ],
        ]);

        return redirect($session->url);
    }

    public function success($auctionId)
    {
        $auction = Auction::findOrFail($auctionId);
        $auction->load('winner', 'user');
        $auction->update(['status' => 'paid']);

        // Notificar al admin
        \Illuminate\Support\Facades\Mail::send([], [], function($m) use ($auction) {
            $buyer = $auction->winner;
            $seller = $auction->user;
            $m->to('info@rialbids.com')
              ->subject('Pago recibido — ' . $auction->title)
              ->html('<div style="font-family:sans-serif;max-width:600px;margin:0 auto;padding:24px">
                <div style="background:#1a3a6b;padding:20px;border-radius:10px 10px 0 0;text-align:center">
                  <h1 style="color:#c9a84c;margin:0;font-size:20px">RialBids — Nuevo pago</h1>
                </div>
                <div style="padding:24px;border:1px solid #e5e7eb;border-top:none;border-radius:0 0 10px 10px">
                  <h2 style="color:#16a34a;margin:0 0 16px">Pago confirmado</h2>
                  <table style="width:100%;font-size:14px;border-collapse:collapse">
                    <tr><td style="padding:8px 0;color:#6b7280">Lote</td><td style="font-weight:700">' . e($auction->title) . ' (#' . $auction->id . ')</td></tr>
                    <tr><td style="padding:8px 0;color:#6b7280">Monto</td><td style="font-weight:700;color:#16a34a">€' . number_format($auction->final_price ?? $auction->current_price, 2) . '</td></tr>
                    <tr><td style="padding:8px 0;color:#6b7280">Comprador</td><td>' . e($buyer ? $buyer->name : '-') . ' (' . e($buyer ? $buyer->email : '-') . ')</td></tr>
                    <tr><td style="padding:8px 0;color:#6b7280">Vendedor</td><td>' . e($seller ? $seller->name : '-') . '</td></tr>
                    <tr><td style="padding:8px 0;color:#6b7280">Dirección envío</td><td>' . e($buyer && $buyer->address ? $buyer->address . ', ' . $buyer->city . ' ' . $buyer->postal_code . ', ' . $buyer->country : 'Sin dirección') . '</td></tr>
                  </table>
                  <a href="https://rialbids.com/admin/pagos" style="background:#1a3a6b;color:#c9a84c;padding:12px 24px;border-radius:8px;text-decoration:none;font-weight:700;display:inline-block;margin-top:20px">Ver en panel →</a>
                </div>
              </div>');
        });

        return redirect()->route('profile.index')
            ->with('success', '¡Pago realizado con éxito! El vendedor se pondrá en contacto contigo.');
    }

    public function webhook(Request $request)
    {
        $payload       = $request->getContent();
        $sigHeader     = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');
        \Log::info('Webhook recibido', ['sig' => $sigHeader, 'headers' => $request->headers->all(), 'payload_inicio' => substr($payload, 0, 200)]);

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        match ($event->type) {
            'checkout.session.completed' => $this->handlePaymentCompleted($event->data->object),
            'charge.dispute.created'     => $this->handleDisputeCreated($event->data->object),
            'charge.dispute.closed'      => $this->handleDisputeClosed($event->data->object),
            default                      => null,
        };

        return response()->json(['status' => 'ok']);
    }

    private function handlePaymentCompleted($session)
    {
        $auctionId = $session->metadata->auction_id;
        $buyerId   = $session->metadata->buyer_id;

        Auction::where('id', $auctionId)->update([
            'status'      => 'paid',
            'winner_id'   => $buyerId,
            'final_price' => $session->amount_total / 100,
        ]);

        $auction = \App\Models\Auction::find($auctionId);
        if ($auction) {
            $buyer = \App\Models\User::find($buyerId);
            $vendor = \App\Models\User::find($auction->user_id);
            if ($buyer) {
                $buyer->notify(new \App\Notifications\PagoConfirmadoComprador($auction));
            }
            if ($vendor) {
                $vendor->notify(new \App\Notifications\PagoConfirmadoVendor($auction));
            }
        }
    }

    private function handleDisputeCreated($dispute)
    {
        $charge    = \Stripe\Charge::retrieve($dispute->charge);
        $auctionId = $charge->metadata->auction_id ?? null;
        if (!$auctionId) return;

        $auction = Auction::find($auctionId);
        if (!$auction) return;

        $auction->update([
            'status'         => 'disputed',
            'dispute_id'     => $dispute->id,
            'dispute_status' => $dispute->status,
            'disputed_at'    => now(),
        ]);

        if ($auction->stripe_transfer_id) {
            try {
                Stripe::setApiKey(config('services.stripe.secret'));
                \Stripe\Transfer::createReversal($auction->stripe_transfer_id, [
                    'amount'      => intval($auction->final_price * 100),
                    'description' => 'Disputa abierta por comprador - ' . $dispute->id,
                ]);
                $auction->update(['payment_released_at' => null]);
            } catch (\Exception $e) {
                \Log::error('Error reversando transfer: ' . $e->getMessage());
            }
        }

        Mail::raw(
            "⚠️ DISPUTA ABIERTA\n\nSubasta: {$auction->title} (ID: {$auction->id})\nMonto: €{$auction->final_price}\nDisputa ID: {$dispute->id}\nRazón: {$dispute->reason}\n\nActuá antes de que venza el plazo de evidencia.",
            fn($m) => $m->to(config('mail.admin_address', 'soporte@rialbids.com'))->subject('⚠️ Disputa Stripe - ' . $auction->title)
        );
    }

    private function handleDisputeClosed($dispute)
    {
        $charge    = \Stripe\Charge::retrieve($dispute->charge);
        $auctionId = $charge->metadata->auction_id ?? null;
        if (!$auctionId) return;

        $auction = Auction::find($auctionId);
        if (!$auction) return;

        $auction->update(['dispute_status' => $dispute->status]);

        if ($dispute->status === 'won') {
            \App\Http\Controllers\StripeConnectController::liberarPago($auction);
        }
    }

    public function confirmarEnvio(Request $request, $auctionId)
    {
        $auction = Auction::findOrFail($auctionId);
        if (auth()->id() !== $auction->user_id) abort(403);

        $request->validate([
            'tracking_number'  => 'required|string|min:8|regex:/^[A-Za-z0-9\-]+$/',
            'tracking_carrier' => 'required|string',
        ]);

        $auction->update([
            'tracking_number'              => $request->tracking_number,
            'tracking_carrier'             => $request->tracking_carrier,
            'shipped_at'                   => now(),
            'status'                       => 'shipped',
            'payment_release_scheduled_at' => now()->addHours(72),
        ]);

        return back()->with('success', 'Tracking cargado. El pago se liberará 72hs después de la entrega confirmada.');
    }

    public function confirmarEntrega(Request $request, $auctionId)
    {
        $auction = Auction::findOrFail($auctionId);

        $auction->update([
            'delivered_at'                 => now(),
            'status'                       => 'delivered',
            'payment_release_scheduled_at' => now()->addHours(72),
        ]);

        return back()->with('success', 'Entrega confirmada. El pago al vendedor se liberará en 72 horas si no hay reclamos.');
    }
}
