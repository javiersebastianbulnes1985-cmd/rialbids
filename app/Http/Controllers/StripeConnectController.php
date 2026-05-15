<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Account;
use Stripe\AccountLink;
use Stripe\Transfer;

class StripeConnectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function onboarding()
    {
        $user = Auth::user();
        if (!$user->stripe_account_id) {
            $account = Account::create([
                'type' => 'express',
                'email' => $user->email,
                'capabilities' => [
                    'card_payments' => ['requested' => true],
                    'transfers' => ['requested' => true],
                ],
            ]);
            $user->stripe_account_id = $account->id;
            $user->save();
        }
        $accountLink = AccountLink::create([
            'account' => $user->stripe_account_id,
            'refresh_url' => route('vendor.stripe.onboarding'),
            'return_url' => route('vendor.stripe.callback'),
            'type' => 'account_onboarding',
        ]);
        return redirect($accountLink->url);
    }

    public function callback()
    {
        $user = Auth::user();
        if ($user->stripe_account_id) {
            $account = Account::retrieve($user->stripe_account_id);
            $user->stripe_onboarding_complete = $account->details_submitted;
            $user->save();
        }
        if ($user->stripe_onboarding_complete) {
            return redirect()->route('vendor.index')
                ->with('success', '¡Cuenta de pagos configurada correctamente!');
        }
        return redirect()->route('vendor.index')
            ->with('error', 'El proceso de verificación no se completó. Intentalo de nuevo.');
    }

    public static function liberarPago($auction)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $vendedor = $auction->user;
        if (!$vendedor->stripe_account_id || !$vendedor->stripe_onboarding_complete) {
            return false;
        }
        $totalCentavos = $auction->winning_bid * 100;
        $comision = round($totalCentavos * 0.09) + 300;
        $paraVendedor = $totalCentavos - $comision;
        $transfer = Transfer::create([
            'amount' => $paraVendedor,
            'currency' => 'eur',
            'destination' => $vendedor->stripe_account_id,
            'transfer_group' => 'AUCTION_' . $auction->id,
        ]);
        $auction->stripe_transfer_id = $transfer->id;
        $auction->payment_released_at = now();
        $auction->status = 'completed';
        $auction->save();
        return true;
    }
}
