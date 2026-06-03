<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class ProfileController extends \Illuminate\Routing\Controller
{
    public function index()
    {
        $user = auth()->user();
        $bids = \App\Models\Bid::with('auction')->where('user_id',$user->id)->orderBy('created_at','desc')->get();
        $compras = \App\Models\Auction::with('user')->where('winner_id',$user->id)->whereIn('status',['finished','paid','shipped','delivered','completed'])->orderBy('updated_at','desc')->get();
        $ventas = \App\Models\Auction::with('winner')->where('user_id',$user->id)->whereIn('status',['paid','shipped','delivered','completed'])->orderBy('updated_at','desc')->get();
        return view('profile.index', compact('user','bids','compras','ventas'));
    }

    public function saveAddress(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'address'     => 'nullable|string|max:255',
            'city'        => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country'     => 'nullable|string|max:100',
            'phone'       => 'nullable|string|max:30',
        ]);
        auth()->user()->update($request->only(['address','city','postal_code','country','phone']));
        return redirect()->route('profile.index')->with('address_saved', true);
    }
    public function saveTracking(Request $request, $id)
    {
        $auction = \App\Models\Auction::where('id',$id)->where('user_id',auth()->id())->where('status','paid')->firstOrFail();
        $request->validate(['tracking_number'=>'required|string|max:255','tracking_carrier'=>'required|string|max:255']);
        $auction->update(['tracking_number'=>$request->tracking_number,'tracking_carrier'=>$request->tracking_carrier,'shipped_at'=>now(),'status'=>'shipped']);
        \App\Models\Payment::where('auction_id',$auction->id)->update(['tracking_number'=>$request->tracking_number,'shipping_carrier'=>$request->tracking_carrier,'shipped_at'=>now(),'release_due_at'=>now()->addHours(72),'status'=>'shipped']);
        if($auction->winner){
            \Illuminate\Support\Facades\Mail::send([],[],function($m) use ($auction,$request){
                $m->to($auction->winner->email)->subject('Tu pedido fue enviado — '.$auction->title)->html('<div style="font-family:sans-serif;max-width:600px;margin:0 auto;padding:32px"><h2>📦 Tu pedido está en camino</h2><p>Hola '.e($auction->winner->name).',</p><p>El vendedor despachó tu lote <strong>'.e($auction->title).'</strong>.</p><div style="background:#f3f4f6;border-radius:12px;padding:20px;margin:20px 0"><p style="margin:0 0 8px;font-size:13px;color:#6b7280">Transportista</p><p style="margin:0;font-weight:700">'.e($request->tracking_carrier).'</p><p style="margin:16px 0 8px;font-size:13px;color:#6b7280">Número de seguimiento</p><p style="margin:0;font-weight:700;font-size:18px">'.e($request->tracking_number).'</p></div><p>Tenés 72 horas para reportar problemas desde tu panel.</p><a href="https://rialbids.com/perfil" style="background:#1a56db;color:#fff;padding:12px 24px;border-radius:8px;text-decoration:none;font-weight:700;display:inline-block;margin-top:16px">Ver mi pedido</a></div>');
            });
        }
        return back()->with('success','✅ Tracking guardado. El comprador fue notificado.');
    }
}
