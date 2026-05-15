<?php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use App\Http\Controllers\StripeConnectController;

class LiberarPagosVendedor extends Command
{
    protected $signature = 'pagos:liberar';
    protected $description = 'Libera pagos a vendedores cuando pasaron 7 dias sin confirmacion del comprador';

    public function handle()
    {
        $auctions = Auction::where('status', 'shipped')
            ->where('shipped_at', '<=', now()->subDays(7))
            ->get();

        foreach ($auctions as $auction) {
            $this->info("Liberando pago para subasta #{$auction->id}...");
            $auction->delivered_at = now();
            $auction->status = 'delivered';
            $auction->save();
            StripeConnectController::liberarPago($auction);
            $this->info("Pago liberado para subasta #{$auction->id}");
        }

        $this->info("Total liberados: {$auctions->count()}");
    }
}
