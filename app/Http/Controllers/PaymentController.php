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
        $auction->update(['status' => 'paid']);

        return redirect()->route('profile.index')
            ->with('success', '¡Pago realizado con éxito! El vendedor se pondrá en contacto contigo.');
    }

    public function webhook(Request $request)
    {
        $payload       = $request->getContent();
        $sigHeader     = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');

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
            'tracking_number'  => 'required|string',
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
