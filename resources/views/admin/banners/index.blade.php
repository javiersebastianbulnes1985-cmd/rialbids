@extends('layouts.app')
@section('title','Banners — Admin')
@section('content')

<div style="max-width:1100px;margin:32px auto;padding:0 24px;">

  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
    <h1 style="font-size:22px;font-weight:700;color:#111827;margin:0;">Banners</h1>
    <a href="{{ route('admin.banners.create') }}"
       style="padding:10px 20px;background:#111827;color:#fff;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;">
      + Nuevo banner
    </a>
  </div>

  @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #86efac;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:13px;">
      ✓ {{ session('success') }}
    </div>
  @endif

  @if($banners->isEmpty())
    <div style="text-align:center;padding:60px 0;color:#9ca3af;">
      <p>No hay banners todavía.</p>
      <a href="{{ route('admin.banners.create') }}" style="color:#1a56db;font-size:13px;">Crear el primero →</a>
    </div>
  @else
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">
      <table style="width:100%;border-collapse:collapse;">
        <thead>
          <tr style="background:#f9fafb;border-bottom:1px solid #e5e7eb;">
            <th style="padding:12px 16px;text-align:left;font-size:12px;color:#6b7280;font-weight:600;text-transform:uppercase;">Banner</th>
            <th style="padding:12px 16px;text-align:center;font-size:12px;color:#6b7280;font-weight:600;text-transform:uppercase;">Estado</th>
            <th style="padding:12px 16px;text-align:center;font-size:12px;color:#6b7280;font-weight:600;text-transform:uppercase;">Orden</th>
            <th style="padding:12px 16px;text-align:right;font-size:12px;color:#6b7280;font-weight:600;text-transform:uppercase;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($banners as $banner)
            <tr style="border-bottom:1px solid #f3f4f6;">
              <td style="padding:14px 16px;">
                <div style="display:flex;align-items:center;gap:12px;">
                  @if($banner->imagen_path)
                    <img src="{{ asset('storage/'.$banner->imagen_path) }}" style="width:80px;height:48px;object-fit:cover;border-radius:6px;border:1px solid #e5e7eb;">
                  @else
                    <div style="width:80px;height:48px;background:#f3f4f6;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:11px;color:#9ca3af;">Sin imagen</div>
                  @endif
                  <div>
                    <p style="font-size:13px;font-weight:600;color:#111827;margin:0;">{{ $banner->titulo }}</p>
                    @if($banner->subtitulo)
                      <p style="font-size:11px;color:#9ca3af;margin:2px 0 0;">{{ Str::limit($banner->subtitulo, 50) }}</p>
                    @endif
                  </div>
                </div>
              </td>
              <td style="padding:14px 16px;text-align:center;">
                <form method="POST" action="{{ route('admin.banners.toggle', $banner->id) }}">
                  @csrf
                  <button type="submit" style="background:{{ $banner->activo?'#f0fdf4':'#f3f4f6' }};color:{{ $banner->activo?'#16a34a':'#6b7280' }};border:1px solid {{ $banner->activo?'#86efac':'#e5e7eb' }};padding:4px 12px;border-radius:20px;font-size:11px;font-weight:600;cursor:pointer;">
                    {{ $banner->activo ? 'Activo' : 'Inactivo' }}
                  </button>
                </form>
              </td>
              <td style="padding:14px 16px;text-align:center;font-size:13px;color:#6b7280;">{{ $banner->orden }}</td>
              <td style="padding:14px 16px;text-align:right;">
                <form method="POST" action="{{ route('admin.banners.destroy', $banner->id) }}" onsubmit="return confirm('¿Eliminar este banner?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" style="background:#fef2f2;color:#dc2626;border:1px solid #fca5a5;padding:6px 12px;border-radius:6px;font-size:12px;font-weight:600;cursor:pointer;">
                    Eliminar
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>

@endsection
