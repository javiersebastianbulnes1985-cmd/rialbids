<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use App\Http\Controllers\StripeConnectController;

class LiberarPagosVendedor extends Command
{
    protected $signature = 'pagos:liberar';
    protected $description = 'Libera pagos a vendedores 72hs post-entrega si no hay disputas activas';

    public function handle()
    {
        $auctions = Auction::where('status', 'delivered')
            ->whereNotNull('payment_release_scheduled_at')
            ->where('payment_release_scheduled_at', '<=', now())
            ->whereNull('payment_released_at')
            ->whereNull('dispute_id')
            ->get();

        if ($auctions->isEmpty()) {
            $this->info('No hay pagos pendientes de liberar.');
            return;
        }

        foreach ($auctions as $auction) {
            try {
                $this->info("Liberando pago subasta #{$auction->id} - {$auction->title} - €{$auction->final_price}");
                $released = StripeConnectController::liberarPago($auction);
                if ($released) {
                    $this->info("✓ Pago liberado correctamente");
                } else {
                    $this->warn("⚠ No se pudo liberar - vendor sin cuenta Stripe configurada");
                }
            } catch (\Exception $e) {
                $this->error("✗ Error subasta #{$auction->id}: " . $e->getMessage());
                \Log::error("pagos:liberar error subasta {$auction->id}: " . $e->getMessage());
            }
        }

        $this->info("Total procesados: {$auctions->count()}");
    }
}
