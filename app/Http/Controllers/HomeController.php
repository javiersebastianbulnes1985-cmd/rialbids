<?php
// ─── app/Http/Controllers/HomeController.php ─────────────────────────────────

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // Subastas destacadas
        $featured = Auction::active()
            ->featured()
            ->with(['primaryImage', 'category', 'currentLeader'])
            ->orderBy('ends_at')
            ->limit(6)
            ->get();

        // Terminando pronto (menos de 1 hora)
        $endingSoon = Auction::active()
            ->endingSoon()
            ->with(['primaryImage', 'category'])
            ->limit(8)
            ->get();

        // Nuevas incorporaciones
        $newest = Auction::active()
            ->with(['primaryImage', 'category'])
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        // Categorías principales para el menú
        $categories = Category::active()
            ->parents()
            ->with('children')
            ->orderBy('sort_order')
            ->get();

        return view('home', compact('featured', 'endingSoon', 'newest', 'categories'));
    }
}


// ─── app/Console/Commands/FinishAuctions.php ─────────────────────────────────
// Comando que corre cada minuto via scheduler para cerrar subastas terminadas

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
            $bidService->finishAuction($auction);
            $this->info("✅ Subasta #{$auction->id} '{$auction->title}' finalizada.");
        }

        $this->info("Total: {$expired->count()} subastas procesadas.");
    }
}
