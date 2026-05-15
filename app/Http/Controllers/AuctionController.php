<?php
namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Banner;
use App\Models\Bid;
use App\Models\User;
use App\Notifications\SuperadoEnPuja;
use Illuminate\Http\Request;
use App\Http\Controllers\StripeConnectController;
use Illuminate\Support\Facades\DB;

class AuctionController extends \Illuminate\Routing\Controller
{
    public function home(Request $request)
    {
        $query = Auction::where('status', 'active');

        if ($request->filled('q')) {
            $query->where('title', 'like', '%'.$request->q.'%');
        }

        if ($request->filled('categoria')) {
            $query->where('lot_category', $request->categoria);
        }

        $auctions = $query->orderBy('end_time', 'asc')->get();

        $finalizadas = Auction::where('status', 'finished')
            ->orderBy('end_time', 'desc')
            ->limit(8)
            ->get();

        $finaliza_pronto = Auction::where('status', 'active')
            ->where('end_time', '>', now())
            ->orderBy('end_time', 'asc')
            ->limit(8)
            ->get();

        $recientes = Auction::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        $banner = Banner::where('activo', true)
            ->orderBy('orden')
            ->first();

        return view('home', compact('auctions', 'finalizadas', 'finaliza_pronto', 'recientes', 'banner'));
    }

    public function index(Request $request)
    {
        return $this->home($request);
    }

    public function finalizadas(Request $request)
    {
        $categorias = [
            'arte'          => 'Arte',
            'joyeria'       => 'Joyería',
            'relojes'       => 'Relojes',
            'moda'          => 'Moda',
            'coleccionismo' => 'Coleccionismo',
            'electronica'   => 'Electrónica',
            'hogar'         => 'Hogar',
            'otros'         => 'Otros',
        ];
        $catActual = $request->get('categoria', '');
        $busqueda  = $request->get('q', '');

        $query = Auction::where('status', 'finished');
        if ($catActual) $query->where('lot_category', $catActual);
        if ($busqueda)  $query->where('title', 'like', "%{$busqueda}%");

        $finalizadas = $query->orderBy('end_time', 'desc')->paginate(16);

        return view('auctions.finalizadas', compact('finalizadas', 'categorias', 'catActual', 'busqueda'));
    }

    public function show($id)
    {
        $auction = Auction::findOrFail($id);
        $bids    = $auction->bids()->take(10)->get();

        $auction->increment('views_count');

        $related = Auction::where('status', 'active')
            ->where('id', '!=', $id)
            ->where('lot_category', $auction->lot_category)
            ->limit(4)
            ->get();

        return view('auctions.show', compact('auction', 'bids', 'related'));
    }

    public function bid(Request $request, $id)
    {
        $auction = Auction::findOrFail($id);

        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $minimum = $auction->nextMinimumBid();

        if ($request->amount < $minimum) {
            return back()->with('error', "La puja mínima es €" . number_format($minimum, 0, ',', '.'));
        }

        $previousBidderId = Bid::where('auction_id', $auction->id)
            ->orderBy('amount', 'desc')
            ->value('user_id');

        DB::transaction(function () use ($auction, $request) {
            Bid::create([
                'auction_id' => $auction->id,
                'amount'     => $request->amount,
                'ip_address' => request()->ip(),
                'user_id'    => auth()->id() ?? 1,
            ]);

            $endTime = $auction->end_time;
            if ($endTime && $endTime->diffInSeconds(now()) > -120 && $endTime->isFuture()) {
                $auction->end_time = $endTime->addMinutes(2);
            }

            $auction->current_price = $request->amount;
            $auction->increment('total_bids');
            $auction->save();
        });

        if ($previousBidderId && $previousBidderId !== auth()->id()) {
            $previousBidder = User::find($previousBidderId);
            if ($previousBidder) {
                $previousBidder->notify(new SuperadoEnPuja($auction, $request->amount));
            }
        }

        return back()->with('success', '¡Puja realizada con éxito!');
    }
public function confirmarEntrega(Request $request, $id)
    {
        $auction = Auction::findOrFail($id);

        if ($auction->winner_id !== auth()->id()) {
            abort(403);
        }

        if ($auction->status !== 'shipped') {
            return back()->with('error', 'El lote aún no fue enviado.');
        }

        $auction->delivered_at = now();
        $auction->status = 'delivered';
        $auction->save();

        StripeConnectController::liberarPago($auction);

        return back()->with('success', '¡Recepción confirmada! El pago fue liberado al vendedor.');
    }
}
