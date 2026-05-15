<?php

namespace App\Services;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\User;
use App\Models\AuctionNotification;
use App\Events\NewBidPlaced;
use App\Events\AuctionExtended;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BidService
{
    /**
     * Procesa una puja. Es el método central de RialBids.
     * Maneja validaciones, anti-sniping, proxy bidding y notificaciones.
     *
     * @return array ['success' => bool, 'message' => string, 'bid' => Bid|null]
     */
    public function placeBid(Auction $auction, User $bidder, float $amount): array
    {
        // ── VALIDACIONES PREVIAS ───────────────────────────────────────────────

        if (!$auction->isActive()) {
            return $this->fail('Esta subasta no está activa.');
        }

        if (!$auction->isStarted()) {
            return $this->fail('Esta subasta aún no ha comenzado.');
        }

        if ($auction->isEnded()) {
            return $this->fail('Esta subasta ya ha finalizado.');
        }

        if ($auction->user_id === $bidder->id) {
            return $this->fail('No podés pujar en tu propia subasta.');
        }

        if (!$bidder->canBid()) {
            return $this->fail('Tu cuenta no está habilitada para pujar. Verificá tu email.');
        }

        if (!$auction->isValidBid($amount)) {
            return $this->fail(
                "La puja mínima es €" . number_format($auction->minimumBid(), 2, ',', '.')
            );
        }

        // ── TRANSACCIÓN ATÓMICA ───────────────────────────────────────────────
        // Usamos DB::transaction con SELECT FOR UPDATE para evitar race conditions
        // (dos personas pujando exactamente al mismo tiempo)

        return DB::transaction(function () use ($auction, $bidder, $amount) {

            // Bloquear el registro de la subasta para esta transacción
            $auction = Auction::lockForUpdate()->find($auction->id);

            // Re-validar dentro de la transacción (puede haber cambiado)
            if (!$auction->isValidBid($amount)) {
                return $this->fail(
                    "Alguien pujó mientras enviabas. La puja mínima ahora es €" .
                    number_format($auction->minimumBid(), 2, ',', '.')
                );
            }

            $previousLeaderId = $auction->current_winner_id;

            // ── MARCAR PUJA ANTERIOR COMO SUPERADA ────────────────────────────
            Bid::where('auction_id', $auction->id)
               ->where('status', 'active')
               ->update(['status' => 'outbid']);

            // ── CREAR LA NUEVA PUJA ───────────────────────────────────────────
            $bid = Bid::create([
                'auction_id'         => $auction->id,
                'user_id'            => $bidder->id,
                'amount'             => $amount,
                'status'             => 'active',
                'triggered_extension' => false,
                'ip_address'         => request()->ip(),
                'user_agent'         => request()->userAgent(),
            ]);

            // ── ACTUALIZAR LA SUBASTA ─────────────────────────────────────────
            $auction->current_price     = $amount;
            $auction->current_winner_id = $bidder->id;
            $auction->total_bids        = $auction->total_bids + 1;

            // ── ANTI-SNIPING ──────────────────────────────────────────────────
            $extended = false;
            if ($auction->shouldExtend()) {
                $auction->extendTime();
                $bid->triggered_extension = true;
                $bid->seconds_extended    = $auction->anti_snipe_minutes * 60;
                $bid->save();
                $extended = true;

                Log::info("RialBids Anti-snipe: Subasta #{$auction->id} extendida {$auction->anti_snipe_minutes} minutos.");
            }

            $auction->save();

            // ── NOTIFICACIONES ────────────────────────────────────────────────
            $this->sendNotifications($auction, $bid, $previousLeaderId);

            // ── EVENTOS WEBSOCKET (tiempo real) ───────────────────────────────
            broadcast(new NewBidPlaced($auction, $bid, $bidder))->toOthers();

            if ($extended) {
                broadcast(new AuctionExtended($auction))->toOthers();
            }

            return [
                'success'  => true,
                'message'  => $extended
                    ? "¡Puja registrada! El tiempo se extendió {$auction->anti_snipe_minutes} minutos (anti-sniping)."
                    : '¡Puja registrada correctamente!',
                'bid'      => $bid,
                'extended' => $extended,
                'new_ends_at' => $auction->ends_at->toIso8601String(),
            ];
        });
    }

    /**
     * Compra inmediata (Buy Now) — omite el sistema de pujas
     */
    public function buyNow(Auction $auction, User $buyer): array
    {
        if (!$auction->hasBuyNow()) {
            return $this->fail('Esta subasta no tiene opción de compra inmediata.');
        }

        if (!$auction->isActive() || $auction->isEnded()) {
            return $this->fail('La subasta no está disponible para compra inmediata.');
        }

        if ($auction->user_id === $buyer->id) {
            return $this->fail('No podés comprar tu propia subasta.');
        }

        return DB::transaction(function () use ($auction, $buyer) {
            $auction = Auction::lockForUpdate()->find($auction->id);

            // Crear la puja al precio de Buy Now
            $bid = Bid::create([
                'auction_id' => $auction->id,
                'user_id'    => $buyer->id,
                'amount'     => $auction->buy_now_price,
                'status'     => 'won',
            ]);

            // Finalizar la subasta inmediatamente
            $auction->update([
                'status'      => 'finished',
                'winner_id'   => $buyer->id,
                'final_price' => $auction->buy_now_price,
                'finished_at' => now(),
                'ends_at'     => now(),
            ]);

            // Notificar al ganador
            AuctionNotification::create([
                'user_id'    => $buyer->id,
                'auction_id' => $auction->id,
                'type'       => 'auction_won',
                'data'       => ['amount' => $auction->buy_now_price, 'type' => 'buy_now'],
            ]);

            // Notificar al seller
            AuctionNotification::create([
                'user_id'    => $auction->user_id,
                'auction_id' => $auction->id,
                'type'       => 'new_bid',
                'data'       => ['message' => 'Tu item fue vendido por compra inmediata.'],
            ]);

            return [
                'success' => true,
                'message' => '¡Compra realizada! Procedé al pago.',
                'bid'     => $bid,
            ];
        });
    }

    /**
     * Finaliza una subasta — lo llama el scheduler automáticamente
     */
    public function finishAuction(Auction $auction): void
    {
        if (!$auction->isActive() || !$auction->isEnded()) {
            return;
        }

        DB::transaction(function () use ($auction) {
            $winningBid = Bid::where('auction_id', $auction->id)
                             ->where('status', 'active')
                             ->orderByDesc('amount')
                             ->first();

            if (!$winningBid) {
                // Sin pujas — subasta fallida
                $auction->update(['status' => 'failed', 'finished_at' => now()]);
                return;
            }

            // Verificar precio de reserva
            if (!$auction->reserveMet()) {
                // No se alcanzó el precio de reserva
                $auction->update(['status' => 'failed', 'finished_at' => now()]);

                // Notificar al pujador líder que no se alcanzó la reserva
                AuctionNotification::create([
                    'user_id'    => $winningBid->user_id,
                    'auction_id' => $auction->id,
                    'type'       => 'auction_lost',
                    'data'       => ['reason' => 'reserve_not_met'],
                ]);
                return;
            }

            // ¡Hay ganador!
            $winningBid->update(['status' => 'won']);

            // Marcar el resto como perdedoras
            Bid::where('auction_id', $auction->id)
               ->where('status', 'outbid')
               ->update(['status' => 'lost']);

            $auction->update([
                'status'      => 'finished',
                'winner_id'   => $winningBid->user_id,
                'final_price' => $winningBid->amount,
                'finished_at' => now(),
            ]);

            // Notificaciones
            AuctionNotification::create([
                'user_id'    => $winningBid->user_id,
                'auction_id' => $auction->id,
                'type'       => 'auction_won',
                'data'       => ['amount' => $winningBid->amount],
            ]);

            AuctionNotification::create([
                'user_id'    => $auction->user_id,
                'auction_id' => $auction->id,
                'type'       => 'new_bid',
                'data'       => ['message' => '¡Tu subasta finalizó con éxito!', 'amount' => $winningBid->amount],
            ]);

            Log::info("RialBids: Subasta #{$auction->id} finalizada. Ganador: #{$winningBid->user_id}. Monto: {$winningBid->amount}");
        });
    }

    // ─── PRIVADOS ─────────────────────────────────────────────────────────────

    private function sendNotifications(Auction $auction, Bid $bid, ?int $previousLeaderId): void
    {
        // Notificar al anterior líder que fue superado
        if ($previousLeaderId && $previousLeaderId !== $bid->user_id) {
            AuctionNotification::create([
                'user_id'    => $previousLeaderId,
                'auction_id' => $auction->id,
                'type'       => 'outbid',
                'data'       => [
                    'new_amount' => $bid->amount,
                    'auction_title' => $auction->title,
                ],
            ]);
        }

        // Notificar al seller de nueva puja
        AuctionNotification::create([
            'user_id'    => $auction->user_id,
            'auction_id' => $auction->id,
            'type'       => 'new_bid',
            'data'       => [
                'amount'   => $bid->amount,
                'bidder'   => $bid->user->name,
                'total_bids' => $auction->total_bids,
            ],
        ]);
    }

    private function fail(string $message): array
    {
        return ['success' => false, 'message' => $message, 'bid' => null];
    }
}
