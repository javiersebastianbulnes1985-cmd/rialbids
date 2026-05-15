<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Services\BidService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BidController extends Controller
{
    public function __construct(private BidService $bidService) {}

    /**
     * POST /auctions/{auction}/bid
     * Recibe la puja del formulario y la procesa
     */
    public function store(Request $request, Auction $auction): JsonResponse
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
        ]);

        $result = $this->bidService->placeBid(
            auction: $auction,
            bidder:  $request->user(),
            amount:  (float) $request->amount,
        );

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
            ], 422);
        }

        return response()->json([
            'success'      => true,
            'message'      => $result['message'],
            'current_price' => number_format($auction->fresh()->current_price, 2, '.', ''),
            'total_bids'   => $auction->fresh()->total_bids,
            'extended'     => $result['extended'] ?? false,
            'new_ends_at'  => $result['new_ends_at'] ?? null,
            'minimum_bid'  => number_format($auction->fresh()->minimumBid(), 2, '.', ''),
        ]);
    }

    /**
     * GET /auctions/{auction}/bids
     * Devuelve el historial de pujas en JSON (para actualizar la tabla en vivo)
     */
    public function history(Auction $auction): JsonResponse
    {
        $bids = $auction->latestBids()
            ->with('user:id,name,country')
            ->get()
            ->map(fn($bid) => [
                'id'         => $bid->id,
                'amount'     => number_format($bid->amount, 2, '.', ''),
                'bidder'     => $this->anonymizeName($bid->user->name),
                'country'    => $bid->user->country,
                'status'     => $bid->status,
                'extended'   => $bid->triggered_extension,
                'created_at' => $bid->created_at->diffForHumans(),
            ]);

        return response()->json([
            'bids'          => $bids,
            'total_bids'    => $auction->total_bids,
            'current_price' => number_format($auction->current_price, 2, '.', ''),
            'ends_at'       => $auction->ends_at->toIso8601String(),
            'seconds_left'  => $auction->secondsRemaining(),
        ]);
    }

    /**
     * POST /auctions/{auction}/buynow
     * Compra inmediata
     */
    public function buyNow(Request $request, Auction $auction): JsonResponse
    {
        $result = $this->bidService->buyNow(
            auction: $auction,
            buyer:   $request->user(),
        );

        $status = $result['success'] ? 200 : 422;

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
        ], $status);
    }

    // ─── PRIVADOS ─────────────────────────────────────────────────────────────

    /**
     * Anonimiza el nombre como hace Catawiki: "Carlos R."
     */
    private function anonymizeName(string $name): string
    {
        $parts = explode(' ', trim($name));
        $first = $parts[0];
        $last  = isset($parts[1]) ? strtoupper($parts[1][0]) . '.' : '';
        return trim("$first $last");
    }
}
