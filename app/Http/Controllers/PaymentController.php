<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Checkout\Session;

class PaymentController extends \Illuminate\Routing\Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    // Crear sesión de pago para el ganador
    public function checkout($auctionId)
    {
        $auction = Auction::findOrFail($auctionId);

        // Solo el ganador puede pagar
        if (auth()->id() !== $auction->winner_id) {
            abort(403);
        }

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

    // Pago exitoso
    public function success($auctionId)
    {
        $auction = Auction::findOrFail($auctionId);
        $auction->update(['status' => 'paid']);

        return redirect()->route('profile.index')
            ->with('success', '¡Pago realizado con éxito! El vendedor se pondrá en contacto contigo.');
    }

    // Webhook de Stripe
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session   = $event->data->object;
            $auctionId = $session->metadata->auction_id;
            $buyerId   = $session->metadata->buyer_id;

            Auction::where('id', $auctionId)->update([
                'status'      => 'paid',
                'winner_id'   => $buyerId,
                'final_price' => $session->amount_total / 100,
            ]);
        }

        return response()->json(['status' => 'ok']);
    }
}


