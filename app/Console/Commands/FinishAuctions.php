<?php
 
namespace App\Console\Commands;
 
use App\Models\Auction;
use App\Services\BidService;
use Illuminate\Console\Command;
 
class FinishAuctions extends Command
{
    protected $signature   = 'auctions:finish';
    protected $description = 'Finaliza las subastas cuyo tiempo ha expirado';
 
    public function handle(BidService $bidService): void
    {
        $expired = Auction::where('status', 'active')
                          ->where('ends_at', '<=', now())
                          ->get();
 
        if ($expired->isEmpty()) {
            $this->info('No hay subastas para finalizar.');
            return;
        }
 
        foreach ($expired as $auction) {
            try {
                $bidService->finishAuction($auction);
                $this->info("✅ Subasta #{$auction->id} '{$auction->title}' finalizada.");
            } catch (\Exception $e) {
                $this->error("❌ Error en subasta #{$auction->id}: " . $e->getMessage());
            }
        }
 
        $this->info("Total: {$expired->count()} subastas procesadas.");
    }
}