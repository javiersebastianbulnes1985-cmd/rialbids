@extends('layouts.app')
@section('title','Editar Banner')
@section('content')
<div style="max-width:700px;margin:40px auto;padding:0 24px;">
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
<h1 style="font-size:20px;font-weight:700;margin:0;">Editar Banner</h1>
<a href="/admin/banners" style="font-size:13px;color:#6b7280;text-decoration:none;">Volver</a>
</div>
<form action="/admin/banners/{{ $banner->id }}/update" method="POST" enctype="multipart/form-data" style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:28px;display:flex;flex-direction:column;gap:18px;">
@csrf
<div><label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Titulo</label>
<input type="text" name="titulo" value="{{ $banner->titulo }}" required style="width:100%;padding:10px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:14px;box-sizing:border-box;"></div>
<div><label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Subtitulo</label>
<input type="text" name="subtitulo" value="{{ $banner->subtitulo }}" style="width:100%;padding:10px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:14px;box-sizing:border-box;"></div>
<div><label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Texto del boton</label>
<input type="text" name="link_texto" value="{{ $banner->link_texto }}" style="width:100%;padding:10px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:14px;box-sizing:border-box;"></div>
<div><label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Imagen</label>
@if($banner->imagen_path)
<img src="{{ asset('storage/'.$banner->imagen_path) }}" style="width:100%;height:140px;object-fit:cover;border-radius:6px;margin-bottom:10px;">
@endif
<input type="file" name="imagen" accept="image/*" style="font-size:13px;">
<p style="font-size:11px;color:#9ca3af;margin-top:4px;">Recomendado: 1400x400px</p></div>
<div style="display:flex;align-items:center;gap:10px;">
<input type="checkbox" name="activo" id="activo" {{ $banner->activo ? 'checked' : '' }}>
<label for="activo" style="font-size:13px;color:#374151;">Banner activo</label></div>
<button type="submit" style="padding:12px;background:#111827;color:#fff;border:none;border-radius:6px;font-size:14px;font-weight:600;cursor:pointer;">Guardar cambios</button>
</form></div>
@endsection
