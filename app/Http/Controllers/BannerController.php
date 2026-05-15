<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends \Illuminate\Routing\Controller
{
    public function index()
    {
        $banners = Banner::orderBy('orden')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo'    => 'required|string|max:255',
            'link'      => 'nullable|url',
        ]);

        $banner = new Banner();
        $banner->titulo      = $request->titulo;
        $banner->subtitulo   = $request->subtitulo;
        $banner->link        = $request->link;
        $banner->link_texto  = $request->link_texto ?? 'Explorar artículos';
        $banner->activo      = $request->has('activo');
        $banner->orden       = $request->orden ?? 0;

        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            $file    = $request->file('imagen');
            $pubPath = public_path('storage/banners');
            if (!is_dir($pubPath)) mkdir($pubPath, 0755, true);
            $fn = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move($pubPath, $fn);
            $banner->imagen_path = 'banners/'.$fn;
        }

        $banner->save();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner creado correctamente.');
    }

    public function destroy($id)
    {
        Banner::findOrFail($id)->delete();
        return back()->with('success', 'Banner eliminado.');
    }

    public function toggle($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->activo = !$banner->activo;
        $banner->save();
        return back()->with('success', 'Estado actualizado.');
    }
}
