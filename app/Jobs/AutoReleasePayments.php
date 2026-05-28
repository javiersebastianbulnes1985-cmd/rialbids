<?php
namespace App\Jobs;

use App\Models\Auction;
use App\Http\Controllers\StripeConnectController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AutoReleasePayments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $auctions = Auction::where('status', 'delivered')
            ->whereNotNull('payment_release_scheduled_at')
            ->where('payment_release_scheduled_at', '<=', now())
            ->whereNull('payment_released_at')
            ->whereNull('dispute_id')
            ->get();

        foreach ($auctions as $auction) {
            try {
                $released = StripeConnectController::liberarPago($auction);
                if ($released) {
                    Log::info("Pago liberado - Subasta ID: {$auction->id} - €{$auction->final_price}");
                }
            } catch (\Exception $e) {
                Log::error("Error liberando pago subasta {$auction->id}: " . $e->getMessage());
            }
        }
    }
}
