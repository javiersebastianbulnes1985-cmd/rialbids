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
                   w.name as comprador, w.email as comprador_email, w.address as comprador_address, w.city as comprador_city, w.postal_code as comprador_postal, w.country as comprador_country, w.phone as comprador_phone, s.name as vendedor
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
        $gastos = \App\Models\Gasto::orderBy('mes','desc')->get();
        $totalGastos = $gastos->sum('monto');
        return view('admin.finanzas', compact('resumen','escrow','completados','sinPagar','gastos','totalGastos'));
    }


    public function liberarPagoManual($id)
    {
        $auction = Auction::findOrFail($id);
        $ok = \App\Http\Controllers\StripeConnectController::liberarPago($auction);
        return back()->with($ok ? 'success' : 'error', $ok ? '✅ Pago liberado al vendedor.' : '❌ Error al liberar. Verificá Stripe.');
    }

    public function reembolsar($id)
    {
        \Stripe\Stripe::setApiKey(config("services.stripe.secret"));
        $auction = Auction::findOrFail($id);
        try {
            $charges = \Stripe\Charge::search(["query"=>"metadata['auction_id']: '".$id."'"]);
            if ($charges->data) \Stripe\Refund::create(["charge"=>$charges->data[0]->id]);
            $auction->update(['status'=>'cancelled']);
            return back()->with('success','✅ Reembolso procesado.');
        } catch(\Exception $e) {
            return back()->with('error','❌ Error: '.$e->getMessage());
        }
    }

    public function desbloquearUsuario($id)
    {
        AppModelsSER::FINDORFAIL($ID)->UPDATE(['IS_ACTIVE'=>1]);
        RETURN BACK()->WITH('SUCCESS','��� USUARIO DESBLOQUEADO.');
    }

    PUBLIC FUNCTION PAGOS()
    {
        $disputas = DB::select("
            SELECT a.id, a.title, a.final_price, a.dispute_id, a.dispute_status,
                   a.disputed_at, a.stripe_transfer_id, a.payment_released_at,
                   w.name as comprador, w.email as comprador_email,
                   s.name as vendedor, s.email as vendedor_email
            FROM auctions a
            LEFT JOIN users w ON w.id = a.winner_id
            LEFT JOIN users s ON s.id = a.user_id
            WHERE a.dispute_id IS NOT NULL
            ORDER BY a.disputed_at DESC
        ");
        $pendientes = DB::select("
            SELECT a.id, a.title, a.final_price, a.status,
                   a.tracking_number, a.tracking_carrier, a.shipped_at,
                   a.delivered_at, a.payment_release_scheduled_at, a.payment_released_at,
                   w.name as comprador, s.name as vendedor
            FROM auctions a
            LEFT JOIN users w ON w.id = a.winner_id
            LEFT JOIN users s ON s.id = a.user_id
            WHERE a.status IN ('paid','shipped','delivered')
            AND a.dispute_id IS NULL
            ORDER BY a.updated_at DESC
        ");
        $disputasComprador = DB::table('disputes as d')
            ->leftJoin('auctions as a', 'a.id', '=', 'd.auction_id')
            ->leftJoin('users as b', 'b.id', '=', 'd.buyer_id')
            ->leftJoin('users as s', 's.id', '=', 'd.seller_id')
            ->select('d.*', 'a.title as lote_title', 'a.final_price', 'b.name as comprador', 'b.email as comprador_email', 's.name as vendedor')
            ->orderByDesc('d.created_at')
            ->get();

        return view('admin.pagos', compact('disputas','pendientes','disputasComprador'));
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
        $auction = Auction::findOrFail($id);
        $dias = $auction->starts_at && $auction->end_time
            ? (int) \Carbon\Carbon::parse($auction->starts_at)->diffInDays(\Carbon\Carbon::parse($auction->end_time))
            : 30;
        $auction->status = 'active';
        $auction->starts_at = now()->format('Y-m-d H:i:s');
        $auction->end_time = now()->addDays($dias)->format('Y-m-d H:i:s');
        $auction->save();

        // Notificar al vendor
        if ($auction->user) {
            $auction->user->notify(new \App\Notifications\LoteAprobado($auction));
        }

        return back()->with('success','Lote aprobado y vendor notificado.');
    }

    public function reject(Request $request, $id)
    {
        $auction = Auction::findOrFail($id);
        $auction->status = 'cancelled';
        $auction->rejection_reason = $request->reason ?? 'Rechazado por el administrador';
        $auction->save();

        // Notificar al vendor
        if ($auction->user) {
            $auction->user->notify(new \App\Notifications\LoteRechazado($auction));
        }

        return redirect()->route('admin.index')->with('success','Lote rechazado y vendor notificado.');
    }

    public function destroy(Request $request, $id)
    {
        $auction = Auction::findOrFail($id);
        $motivo = $request->input('motivo', 'Cancelado por administración');

        $auction->status = 'cancelled';
        $auction->rejection_reason = $motivo;
        $auction->save();

        // Notificar a todos los pujadores
        $pujadores = \App\Models\Bid::where('auction_id', $id)
            ->with('user')
            ->get()
            ->pluck('user')
            ->unique('id')
            ->filter();

        foreach ($pujadores as $pujador) {
            $pujador->notify(new \App\Notifications\LoteCancelado($auction, $motivo));
        }

        // Notificar al vendor
        if ($auction->user) {
            $auction->user->notify(new \App\Notifications\LoteCancelado($auction, $motivo));
        }

        return back()->with('success', 'Lote cancelado. ' . $pujadores->count() . ' pujadores notificados.');
    }

    public function automatizaciones()
    {
        $filtroReales = function ($q) {
            $q->where('email', 'not like', '%test%')
               ->where('email', 'not like', '%@test.%')
               ->where('email', 'not like', '%ejemplo%')
               ->where('email', 'not like', '%@rialbids.com');
        };

        $vendedoresSinLotes = \App\Models\User::where('role', 'seller')
            ->whereDoesntHave('auctions')
            ->where($filtroReales)
            ->count();

        $vendedoresSinStripe = \App\Models\User::where('role', 'seller')
            ->where(function ($q) {
                $q->whereNull('stripe_account_id')->orWhere('stripe_onboarding_complete', false);
            })
            ->count();

        $compradoresSinPujas = \App\Models\User::where('role', 'bidder')->count();

        $automatizaciones = [
            [
                'nombre'      => 'Invitacion a publicar',
                'clase'       => 'InvitacionPublicarVendor',
                'descripcion' => 'Email personal invitando a vendedores sin lotes a publicar su primera pieza.',
                'idiomas'     => 'ES / PT / EN / DE',
                'pendientes'  => $vendedoresSinLotes,
                'etiqueta'    => 'vendedores sin lotes',
                'accion'      => 'invitacion_vendedores',
            ],
            [
                'nombre'      => 'Bienvenida vendedor',
                'clase'       => 'BienvenidaVendor',
                'descripcion' => 'Se envia automaticamente cuando un vendedor se registra.',
                'idiomas'     => 'ES / PT / EN / DE',
                'pendientes'  => null,
                'etiqueta'    => 'automatico al registrarse',
                'accion'      => null,
            ],
            [
                'nombre'      => 'Newsletter semanal',
                'clase'       => 'NewsletterSemanal',
                'descripcion' => 'Resumen semanal de lotes destacados. Cron: lunes 09:00.',
                'idiomas'     => 'ES / PT / EN / DE',
                'pendientes'  => null,
                'etiqueta'    => 'cron semanal',
                'accion'      => null,
            ],
            [
                'nombre'      => 'Lotes que finalizan',
                'clase'       => 'LotesFinalizanPronto',
                'descripcion' => 'Aviso de lotes proximos a cerrar. Cron: diario 10:00.',
                'idiomas'     => 'ES / PT / EN / DE',
                'pendientes'  => null,
                'etiqueta'    => 'cron diario',
                'accion'      => null,
            ],
        ];

        return view('admin.automatizaciones', compact('automatizaciones', 'vendedoresSinLotes', 'vendedoresSinStripe', 'compradoresSinPujas'));
    }

    public function dispararAutomatizacion(\Illuminate\Http\Request $request)
    {
        $accion = $request->input('accion');

        if ($accion === 'invitacion_vendedores') {
            $vendedores = \App\Models\User::where('role', 'seller')
                ->whereDoesntHave('auctions')
                ->where('email', 'not like', '%test%')
                ->where('email', 'not like', '%@test.%')
                ->where('email', 'not like', '%ejemplo%')
                ->where('email', 'not like', '%@rialbids.com')
                ->get();
            $enviados = 0;
            foreach ($vendedores as $v) {
                try {
                    $v->notify(new \App\Notifications\InvitacionPublicarVendor());
                    $enviados++;
                } catch (\Exception $e) {
                    \Log::error('Error enviando invitacion a ' . $v->email . ': ' . $e->getMessage());
                }
            }
            return back()->with('success', "Invitacion enviada a {$enviados} vendedor(es) sin lotes.");
        }

        return back()->with('error', 'Accion no reconocida.');
    }

    public function previewEmail($tipo)
    {
        $fake = new \App\Models\User();
        $fake->name = 'Nombre del vendedor';
        $fake->email = 'ejemplo@email.com';

        $vistas = [
            'invitacion_publicar' => 'emails.invitacion_publicar',
            'invitacion_publicar_pt' => 'emails.invitacion_publicar_pt',
            'invitacion_publicar_en' => 'emails.invitacion_publicar_en',
            'invitacion_publicar_de' => 'emails.invitacion_publicar_de',
        ];

        if (!isset($vistas[$tipo])) {
            abort(404);
        }

        return view($vistas[$tipo], ['user' => $fake]);
    }
}
