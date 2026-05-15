<?php
namespace App\Http\Controllers;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminController extends \Illuminate\Routing\Controller
{
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
        $auction->title         = $request->title;
        $auction->description   = $request->description;
        $auction->base_price    = $request->base_price;
        $auction->min_increment = $request->min_increment ?? 10;
        $auction->reserve_price = $request->reserve_price ?: null;
        $auction->end_time      = Carbon::parse($request->end_time)->format('Y-m-d H:i:s');
        $auction->status        = $request->status ?? $auction->status;
        $auction->lot_category  = $request->lot_category ?? 'general';
        $auction->video_url     = $request->video_url ?: null;
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

    public function destroy($id)
    {
        Auction::findOrFail($id)->delete();
        return back()->with('success','Lote eliminado.');
    }
}
