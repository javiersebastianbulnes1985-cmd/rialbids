<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Account;
use Stripe\AccountLink;
use Stripe\Transfer;

class StripeConnectController extends Controller
{
    public function onboarding()
    {
        Stripe::setApiKey(config("services.stripe.secret"));
        $user = Auth::user();

        if (!$user->stripe_account_id) {
            try {
                $account = Account::create([
                    "type" => "express",
                    "email" => $user->email,
                    "capabilities" => [
                        "card_payments" => ["requested" => true],
                        "transfers" => ["requested" => true],
                    ],
                ]);
                $user->stripe_account_id = $account->id;
                $user->save();
                Log::info("Stripe account created for user {$user->id}: {$account->id}");
            } catch (\Exception $e) {
                Log::error("Stripe account creation failed for user {$user->id}: " . $e->getMessage());
                return redirect()->route("vendor.index")
                    ->with("error", "Error al conectar con Stripe. Intentalo de nuevo.");
            }
        }

        $accountLink = AccountLink::create([
            "account" => $user->stripe_account_id,
            "refresh_url" => route("vendor.stripe.onboarding"),
            "return_url" => route("vendor.stripe.callback"),
            "type" => "account_onboarding",
        ]);

        return redirect($accountLink->url);
    }

    public function callback()
    {
        Stripe::setApiKey(config("services.stripe.secret"));
        $user = Auth::user();

        if (!$user->stripe_account_id) {
            Log::warning("Stripe callback sin stripe_account_id para user {$user->id}");
            return redirect()->route("vendor.stripe.onboarding")
                ->with("error", "Ocurrio un error. Por favor completa el proceso de nuevo.");
        }

        try {
            $account = Account::retrieve($user->stripe_account_id);
            $user->stripe_onboarding_complete = $account->details_submitted;
            $user->save();
            Log::info("Stripe callback user {$user->id}: details_submitted={$account->details_submitted}");
        } catch (\Exception $e) {
            Log::error("Stripe callback error user {$user->id}: " . $e->getMessage());
        }

        if ($user->stripe_onboarding_complete) {
            return redirect()->route("vendor.index")
                ->with("success", "Cuenta de pagos configurada correctamente!");
        }

        return redirect()->route("vendor.index")
            ->with("error", "El proceso de verificacion no se completo. Intentalo de nuevo.");
    }

    public static function liberarPago($auction)
    {
        Stripe::setApiKey(config("services.stripe.secret"));

        $vendedor = $auction->user;

        if (!$vendedor->stripe_account_id || !$vendedor->stripe_onboarding_complete) {
            Log::error("PAGO NO LIBERADO - Subasta {$auction->id}: vendor {$vendedor->id} ({$vendedor->email}) sin stripe_account_id o onboarding incompleto. REQUIERE ACCION MANUAL EN /admin/pagos");
            try {
                \Illuminate\Support\Facades\Mail::raw(
                    "ALERTA: El pago de la subasta #{$auction->id} NO pudo liberarse automaticamente.\n\nVendedor: {$vendedor->name} ({$vendedor->email})\nStripe Account ID: " . ($vendedor->stripe_account_id ?? "FALTANTE") . "\n\nEntra al panel admin /admin/pagos para liberar manualmente.\n\nEl dinero esta retenido en Stripe, no se perdio.",
                    function($m) {
                        $m->to("info@rialbids.com")->subject("PAGO PENDIENTE - Accion requerida en RialBids");
                    }
                );
            } catch (\Exception $e) {
                Log::error("No se pudo enviar email de alerta admin: " . $e->getMessage());
            }
            return false;
        }

        try {
            $totalCentavos = ($auction->final_price ?? $auction->current_price) * 100;
            $comision = round($totalCentavos * 0.09) + 300;
            $paraVendedor = $totalCentavos - $comision;

            $transfer = Transfer::create([
                "amount" => $paraVendedor,
                "currency" => "eur",
                "destination" => $vendedor->stripe_account_id,
                "transfer_group" => "AUCTION_" . $auction->id,
            ]);

            $auction->stripe_transfer_id = $transfer->id;
            $auction->payment_released_at = now();
            $auction->status = "completed";
            $auction->save();

            Log::info("Pago liberado OK - Subasta {$auction->id}: {$paraVendedor} centavos a {$vendedor->stripe_account_id}");
            return true;
        } catch (\Exception $e) {
            Log::error("Error liberando pago - Subasta {$auction->id}: " . $e->getMessage());
            return false;
        }
    }
}
