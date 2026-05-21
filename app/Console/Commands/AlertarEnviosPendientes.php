<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use App\Models\User;

class AlertarEnviosPendientes extends Command
{
    protected $signature = 'envios:alertar';
    protected $description = 'Cancela subastas donde el vendor no envio en 10 dias';

    public function handle()
    {
        $vencidas = Auction::where('status', 'paid')
            ->where('updated_at', '<=', now()->subDays(10))
            ->get();

        foreach ($vencidas as $auction) {
            $auction->status = 'cancelled';
            $auction->save();
            $this->info("Cancelada #{$auction->id} - vendor no envio en 10 dias");
        }

        $this->info("Total canceladas: {$vencidas->count()}");
    }
}
