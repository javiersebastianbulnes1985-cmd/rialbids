<?php
namespace App\Http\Controllers;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminController extends \Illuminate\Routing\Controller
{
    public function finanzas()
    {
        $resumen = DB::select("
            SELECT
                SUM(CASE WHEN status='completed' THEN final_price * commission_rate / 100 + 3 ELSE 0 END) as comisiones_cobradas,
                SUM(CASE WHEN status IN ('paid','shipped') THEN final_price ELSE 0 END) as escrow_total,
                SUM(CASE WHEN status='completed' THEN final_price ELSE 0 END) as volumen_completado,
                COUNT(CASE WHEN status IN ('paid','shipped') THEN 1 END) as lotes_escrow,
                COUNT(CASE WHEN status='finished' AND winner_id IS NULL THEN 1 END) as sin_pagar,
                COUNT(CASE WHEN status='shipped' AND shipped_at < NOW() - INTERVAL 14 DAY THEN 1 END) as enviados_demorados
            FROM auctions
        ")[0];
        $escrow = DB::select("
            SELECT a.id, a.title, a.final_price, a.commission_rate,
                   a.status, a.shipped_at, a.created_at,
                   w.name as comprador, w.email as comprador_email,
                   s.name as vendedor, s.email as vendedor_email
            FROM auctions a
            LEFT JOIN users w ON w.id = a.winner_id
            LEFT JOIN users s ON s.id = a.user_id
            WHERE a.status IN ('paid','shipped')
            ORDER BY a.updated_at DESC
        ");
        $completados = DB::select("
            SELECT a.id, a.title, a.final_price, a.commission_rate,
                   a.payment_released_at, a.stripe_transfer_id,
                   w.name as comprador, s.name as vendedor
            FROM auctions a
            LEFT JOIN users w ON w.id = a.winner_id
            LEFT JOIN users s ON s.id = a.user_id
            WHERE a.status = 'completed'
            ORDER BY a.payment_released_at DESC
            LIMIT 30
        ");
        $sinPagar = DB::select("
            SELECT a.id, a.title, a.final_price, a.finished_at,
                   w.name as comprador, w.email as comprador_email
            FROM auctions a
            LEFT JOIN users w ON w.id = a.winner_id
            WHERE a.status = 'finished' AND a.winner_id IS NOT NULL
            ORDER BY a.finished_at DESC
            LIMIT 20
        ");
        return view('admin.finanzas', compact('resumen','escrow','completados','sinPagar'));
    }

    public function index()
    {
        $auctions   = Auction::orderBy('created_at','desc')->get();
        $recentBids = Bid::with(['user','auction'])->orderBy('created_at','desc')->limit(20)->get();
        $users      = User::withCount('bids')->orderBy('created_at','desc')->limit(50)->get();
        $totalBids  = Bid::count();
        $totalUsers = User::count();
        return view('admin.index', compact('auctions','recentBids','users','totalBids','totalUsers'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'end_time'   => 'required|date',
        ]);
        $auction = new Auction();
        $auction->title         = $request->title;
        $auction->slug          = Str::slug($request->title).'-'.time();
        $auction->description   = $request->description;
        $auction->base_price    = $request->base_price;
        $auction->current_price = $request->base_price;
        $auction->min_increment = $request->min_increment ?? 10;
        $auction->reserve_price = $request->reserve_price ?: null;
        $auction->end_time      = Carbon::parse($request->end_time)->format('Y-m-d H:i:s');
        $auction->starts_at     = now()->format('Y-m-d H:i:s');
        $auction->status        = $request->status ?? 'active';
        $auction->user_id       = auth()->id() ?? 1;
        $auction->category_id   = $request->category_id ?? 1;
        $auction->lot_category  = $request->lot_category ?? 'general';
        $auction->video_url     = $request->video_url ?: null;
        $auction->total_bids    = 0;
        $pubPath = public_path('storage/auctions');
        if(!is_dir($pubPath)) mkdir($pubPath,0755,true);
        foreach(['image_'=>'image_path','image_2'=>'image_path_2','image_3'=>'image_path_3'] as $input=>$field){
            if($request->hasFile($input)&&$request->file($input)->isValid()){
                $file=$request->file($input);
                $fn=time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                $file->move($pubPath,$fn);
                $auction->$field='auctions/'.$fn;
            }
        }
        $auction->save();
        return redirect()->route('admin.index')->with('success','Lote #'.$auction->id.' creado!');
    }

    public function edit($id)
    {
        $auction = Auction::findOrFail($id);
        return view('admin.edit', compact('auction'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'end_time'   => 'required|date',
        ]);
        $auction = Auction::findOrFail($id);
        $auction->title           = $request->title;
        $auction->description     = $request->description;
        $auction->base_price      = $request->base_price;
        $auction->min_increment   = $request->min_increment ?? 10;
        $auction->reserve_price   = $request->reserve_price ?: null;
        $auction->end_time        = Carbon::parse($request->end_time)->format('Y-m-d H:i:s');
        $auction->status          = $request->status ?? $auction->status;
        $auction->tracking_number = $request->tracking_number ?? $auction->tracking_number;
        $auction->lot_category    = $request->lot_category ?? 'general';
        $auction->video_url       = $request->video_url ?: null;
        $pubPath = public_path('storage/auctions');
        if(!is_dir($pubPath)) mkdir($pubPath,0755,true);
        foreach(['image_'=>'image_path','image_2'=>'image_path_2','image_3'=>'image_path_3'] as $input=>$field){
            if($request->hasFile($input)&&$request->file($input)->isValid()){
                $file=$request->file($input);
                $fn=time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                $file->move($pubPath,$fn);
                $auction->$field='auctions/'.$fn;
            }
        }
        $auction->save();
        return redirect()->route('admin.index')->with('success','Lote #'.$auction->id.' actualizado!');
    }

    public function approve($id)
    {
        Auction::where('id',$id)->update(['status'=>'active']);
        return back()->with('success','Lote aprobado.');
    }

    public function reject(Request $request, $id)
    {
        $auction = Auction::findOrFail($id);
        $auction->status = 'cancelled';
        $auction->rejection_reason = $request->reason ?? 'Rechazado por el administrador';
        $auction->save();
        return redirect()->route('admin.index')->with('success','Lote rechazado correctamente.');
    }

    public function destroy($id)
    {
        Auction::findOrFail($id)->delete();
        return back()->with('success','Lote eliminado.');
    }
}
