@extends('layouts.app')
@section('title','Nuevo Banner — Admin')
@section('content')

<div style="max-width:700px;margin:32px auto;padding:0 24px;">

  <div style="margin-bottom:24px;">
    <a href="{{ route('admin.banners.index') }}" style="font-size:13px;color:#6b7280;text-decoration:none;">← Volver a banners</a>
    <h1 style="font-size:22px;font-weight:700;color:#111827;margin:8px 0 0;">Nuevo Banner</h1>
  </div>

  <form method="POST" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data"
        style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:24px;">
    @csrf

    <div style="margin-bottom:16px;">
      <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Título *</label>
      <input type="text" name="titulo" value="{{ old('titulo') }}" required
             style="width:100%;padding:10px 14px;border:1px solid #e5e7eb;border-radius:8px;font-size:14px;outline:none;box-sizing:border-box;">
    </div>

    <div style="margin-bottom:16px;">
      <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Subtítulo</label>
      <input type="text" name="subtitulo" value="{{ old('subtitulo') }}"
             style="width:100%;padding:10px 14px;border:1px solid #e5e7eb;border-radius:8px;font-size:14px;outline:none;box-sizing:border-box;">
    </div>

    <div style="margin-bottom:16px;">
      <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Imagen de fondo</label>
      <input type="file" name="imagen" accept="image/*"
             style="width:100%;padding:10px 14px;border:1px solid #e5e7eb;border-radius:8px;font-size:14px;box-sizing:border-box;">
      <p style="font-size:11px;color:#9ca3af;margin-top:4px;">Recomendado: 1280x500px</p>
    </div>

    <div style="margin-bottom:16px;">
      <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Link (URL)</label>
      <input type="url" name="link" value="{{ old('link') }}" placeholder="https://rialbids.com/..."
             style="width:100%;padding:10px 14px;border:1px solid #e5e7eb;border-radius:8px;font-size:14px;outline:none;box-sizing:border-box;">
    </div>

    <div style="margin-bottom:16px;">
      <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Texto del botón</label>
      <input type="text" name="link_texto" value="{{ old('link_texto', 'Explorar artículos') }}"
             style="width:100%;padding:10px 14px;border:1px solid #e5e7eb;border-radius:8px;font-size:14px;outline:none;box-sizing:border-box;">
    </div>

    <div style="display:flex;gap:16px;margin-bottom:24px;">
      <div style="flex:1;">
        <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Orden</label>
        <input type="number" name="orden" value="{{ old('orden', 0) }}" min="0"
               style="width:100%;padding:10px 14px;border:1px solid #e5e7eb;border-radius:8px;font-size:14px;outline:none;box-sizing:border-box;">
      </div>
      <div style="flex:1;display:flex;align-items:flex-end;padding-bottom:2px;">
        <label style="display:flex;align-items:center;gap:8px;font-size:13px;font-weight:600;color:#374151;cursor:pointer;">
          <input type="checkbox" name="activo" checked style="width:16px;height:16px;">
          Activo
        </label>
      </div>
    </div>

    <button type="submit"
            style="width:100%;padding:12px;background:#111827;color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;">
      Crear Banner
    </button>
  </form>
</div>

@endsection

