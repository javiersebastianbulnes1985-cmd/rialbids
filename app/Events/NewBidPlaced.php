<?php
// ─── app/Events/NewBidPlaced.php ──────────────────────────────────────────────

namespace App\Events;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewBidPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Auction $auction,
        public Bid     $bid,
        public User    $bidder,
    ) {}

    /**
     * El canal de broadcast — cada subasta tiene su propio canal
     * Ej: auction.42 para la subasta con ID 42
     */
    public function broadcastOn(): array
    {
        return [
            new Channel("auction.{$this->auction->id}"),
        ];
    }

    /**
     * Los datos que llegan al navegador en tiempo real
     */
    public function broadcastWith(): array
    {
        return [
            'auction_id'    => $this->auction->id,
            'current_price' => number_format($this->auction->current_price, 2, '.', ''),
            'total_bids'    => $this->auction->total_bids,
            'bidder_name'   => $this->anonymizeName($this->bidder->name),
            'bidder_country' => $this->bidder->country,
            'bid_id'        => $this->bid->id,
            'minimum_bid'   => number_format($this->auction->minimumBid(), 2, '.', ''),
            'seconds_left'  => $this->auction->secondsRemaining(),
        ];
    }

    public function broadcastAs(): string
    {
        return 'new.bid';
    }

    private function anonymizeName(string $name): string
    {
        $parts = explode(' ', trim($name));
        $first = $parts[0];
        $last  = isset($parts[1]) ? strtoupper($parts[1][0]) . '.' : '';
        return trim("$first $last");
    }
}
