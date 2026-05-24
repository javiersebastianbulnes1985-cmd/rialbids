<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\User;
use App\Notifications\SuperadoEnPuja;

class CerrarSubastas extends Command
{
    protected $signature   = 'subastas:cerrar';
    protected $description = 'Cierra subastas cuyo end_time ya pasó';

    public function handle()
    {
        $vencidas = Auction::where('status', 'active')
            ->where('end_time', '<', now())
            ->get();

        foreach ($vencidas as $auction) {
            $ganador = Bid::where('auction_id', $auction->id)
                ->orderBy('amount', 'desc')
                ->first();

            $auction->status      = 'finished';
            $auction->final_price = $ganador ? $ganador->amount : $auction->current_price;
            $auction->winner_id   = $ganador ? $ganador->user_id : null;
            $auction->save();

            if ($ganador && $ganador->user_id) {
                $user = User::find($ganador->user_id);
                if ($user) {
                    $user->notify(new \App\Notifications\GanadorSubasta($auction));
                }
            }

            $this->info("Cerrada: {$auction->title}");
            if ($ganador) \App\Services\TelegramService::send("🏆 Lote vendido!
📦 " . $auction->title . "
💶 €" . number_format($auction->final_price, 0, ",", ".") . "
👤 Ganador: " . optional($ganador->user)->name);
        }

        $this->info("Total cerradas: {$vencidas->count()}");
    }
}
