<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\Dispute;
use App\Models\User;
use App\Notifications\DisputaAbierta;
use Illuminate\Support\Facades\Notification;

class DisputeController extends Controller
{
    public function create(Auction $auction)
    {
        $user = auth()->user();
        abort_unless($user, 403);

        if ((int) $auction->winner_id !== (int) $user->id) {
            abort(403, 'Solo el ganador del lote puede abrir una disputa.');
        }

        $existing = Dispute::where('auction_id', $auction->id)
            ->where('buyer_id', $user->id)
            ->whereIn('status', ['abierta', 'en_revision'])
            ->first();

        return view('disputes.create', compact('auction', 'existing'));
    }

    public function store(Request $request, Auction $auction)
    {
        $user = auth()->user();
        abort_unless($user, 403);

        if ((int) $auction->winner_id !== (int) $user->id) {
            abort(403, 'Solo el ganador del lote puede abrir una disputa.');
        }

        $data = $request->validate([
            'reason'      => 'required|string|max:120',
            'description' => 'required|string|max:2000',
            'photo'       => 'nullable|image|max:5120',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('disputes', 'public');
        }

        $dispute = Dispute::create([
            'auction_id'  => $auction->id,
            'buyer_id'    => $user->id,
            'seller_id'   => $auction->user_id,
            'reason'      => $data['reason'],
            'description' => $data['description'],
            'photo_path'  => $photoPath,
            'status'      => 'abierta',
        ]);

        $auction->dispute_status = 'abierta';
        $auction->disputed_at    = now();
        $auction->save();

        Notification::route('mail', 'javiersebastianbulnes1985@gmail.com')
            ->notify(new DisputaAbierta($dispute));
        Notification::route('mail', 'soporte@rialbids.com')
            ->notify(new DisputaAbierta($dispute));

        return redirect()->route('disputes.create', $auction)
            ->with('disputa_ok', true);
    }
}
