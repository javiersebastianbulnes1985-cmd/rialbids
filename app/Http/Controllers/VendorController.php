<?php
namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Notifications\LoteEnviado;

class VendorController extends \Illuminate\Routing\Controller
{
    public function index()
    {
        $auctions = Auction::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'pendiente' => $auctions->where('status', 'pending')->count(),
            'activo'    => $auctions->where('status', 'active')->count(),
            'finalizado'=> $auctions->where('status', 'finished')->count(),
            'total'     => $auctions->count(),
        ];

        return view('vendor.index', compact('auctions', 'stats'));
    }

    public function create()
    {
        $uploadToken = session()->get('upload_token') ?: \Illuminate\Support\Str::uuid();
        session()->put('upload_token', $uploadToken);
        return view('vendor.create', compact('uploadToken'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'base_price'  => 'required|numeric|min:20',
            'duracion'    => 'required|integer|in:7,14,21,30',
            'description' => 'required|string|min:80',
            'lot_category'=> 'required|string',
            'condition'   => 'required|string',
            'image'       => 'nullable|image|max:10240',
            'image_2'     => 'nullable|image|max:10240',
            'image_3'     => 'nullable|image|max:10240',
            'image_4'     => 'nullable|image|max:10240',
            'image_5'     => 'nullable|image|max:10240',
            'image_6'     => 'nullable|image|max:10240',
        ]);

        $auction = new Auction();
        $auction->title         = $request->title;
        $auction->slug          = Str::slug($request->title).'-'.time();
        $auction->description   = $request->description;
        $auction->base_price    = $request->base_price;
        $auction->current_price = $request->base_price;
        $auction->min_increment = $request->min_increment ?? 10;
        $auction->reserve_price = $request->reserve_price ?: null;
        $auction->end_time      = now()->addDays((int)$request->duracion)->format('Y-m-d H:i:s');
        $auction->starts_at     = now()->format('Y-m-d H:i:s');
        $auction->status        = 'pending';
        $auction->user_id       = auth()->id();
        $auction->category_id   = $request->category_id ?? 1;
        $auction->lot_category  = $request->lot_category ?? 'general';
        $auction->total_bids    = 0;
        $auction->condition     = $request->condition ?? null;

        $pubPath = public_path('storage/auctions');
        if (!is_dir($pubPath)) mkdir($pubPath, 0755, true);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $fn   = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move($pubPath, $fn);
            $auction->image_path = 'auctions/'.$fn;
        }

        foreach (['image_2'=>'image_path_2','image_3'=>'image_path_3','image_4'=>'image_path_4','image_5'=>'image_path_5','image_6'=>'image_path_6'] as $input => $field) {
            if ($request->hasFile($input) && $request->file($input)->isValid()) {
                $file = $request->file($input);
                $fn   = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                $file->move($pubPath, $fn);
                $auction->$field = 'auctions/'.$fn;
            }
        }

        // URL imagen externa (solo si no subió imagen principal)
        if (empty($auction->image_path) && $request->filled('image_url')) {
            $auction->image_path = $request->image_url;
        }

        // Fotos subidas desde mobile
        if (empty($auction->image_path) && $request->filled('upload_token')) {
            $mobilePhotos = \Illuminate\Support\Facades\Cache::get('mobileupload_' . $request->upload_token, []);
            $fields = ['image_path','image_path_2','image_path_3','image_path_4','image_path_5','image_path_6'];
            foreach ($mobilePhotos as $i => $p) {
                if (isset($fields[$i]) && empty($auction->{$fields[$i]})) {
                    $auction->{$fields[$i]} = $p;
                }
            }
            \Illuminate\Support\Facades\Cache::forget('mobileupload_' . $request->upload_token);
        }

        $auction->save();

        return redirect()->route('vendor.index')
            ->with('success', 'Lote enviado. El admin lo revisará antes de publicarlo.');
    }

    public function edit($id)
    {
        $auction = \App\Models\Auction::findOrFail($id);
        if ($auction->user_id !== auth()->id()) abort(403);
        if ($auction->status !== 'pending') return redirect()->route('vendor.index')->with('error', 'Solo podés editar lotes pendientes.');
        return view('vendor.edit', compact('auction'));
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $auction = \App\Models\Auction::findOrFail($id);
        if ($auction->user_id !== auth()->id()) abort(403);
        if ($auction->status !== 'pending') return redirect()->route('vendor.index')->with('error', 'Solo podés editar lotes pendientes.');

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string|min:80',
            'base_price'  => 'required|numeric|min:20',
            'condition'   => 'required|string',
        ]);

        $auction->title       = $request->title;
        $auction->description = $request->description;
        $auction->base_price  = $request->base_price;
        $auction->current_price = $request->base_price;
        $auction->condition   = $request->condition;
        $auction->reserve_price = $request->reserve_price ?: null;

        $pubPath = public_path('storage/auctions');
        if (!is_dir($pubPath)) mkdir($pubPath, 0755, true);

        foreach (['image'=>'image_path','image_2'=>'image_path_2','image_3'=>'image_path_3','image_4'=>'image_path_4','image_5'=>'image_path_5','image_6'=>'image_path_6'] as $input => $field) {
            if ($request->hasFile($input) && $request->file($input)->isValid()) {
                $file = $request->file($input);
                $fn = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                $file->move($pubPath, $fn);
                $auction->$field = 'auctions/'.$fn;
            }
        }

        $auction->save();
        return redirect()->route('vendor.index')->with('success', 'Lote actualizado. Seguirá en revisión.');
    }

    public function marcarEnviado(Request $request, $id)
    {
        $auction = Auction::findOrFail($id);

        if ($auction->user_id !== auth()->id()) abort(403);

        if ($auction->status !== 'paid') {
            return back()->with('error', 'El lote no está en estado correcto.');
        }

        $request->validate(['tracking_number' => 'required|string|max:255']);

        $auction->tracking_number = $request->tracking_number;
        $auction->shipped_at = now();
        $auction->status = 'shipped';
        $auction->save();

        $winner = User::find($auction->winner_id);
        if ($winner) {
            $winner->notify(new LoteEnviado($auction));
        }

        return back()->with('success', '¡Lote marcado como enviado! El comprador fue notificado.');
    }
}
