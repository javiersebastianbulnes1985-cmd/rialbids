<?php
// ─── app/Events/AuctionExtended.php ──────────────────────────────────────────

namespace App\Events;

use App\Models\Auction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuctionExtended implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Auction $auction) {}

    public function broadcastOn(): array
    {
        return [new Channel("auction.{$this->auction->id}")];
    }

    public function broadcastWith(): array
    {
        return [
            'auction_id'   => $this->auction->id,
            'new_ends_at'  => $this->auction->ends_at->toIso8601String(),
            'seconds_left' => $this->auction->secondsRemaining(),
            'message'      => "⏱ ¡Anti-sniping activado! Tiempo extendido {$this->auction->anti_snipe_minutes} minutos.",
        ];
    }

    public function broadcastAs(): string
    {
        return 'auction.extended';
    }
}
