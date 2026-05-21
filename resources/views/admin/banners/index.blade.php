@extends('layouts.app')
@section('title','Banners — Admin')
@section('content')
<div style="max-width:1100px;margin:0 auto;padding:32px 24px;">
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
<h1 style="font-size:20px;font-weight:700;margin:0;">Banners</h1>
<a href="{{ route('admin.banners.create') }}" style="background:#111827;color:#fff;padding:10px 18px;border-radius:6px;font-size:13px;font-weight:600;text-decoration:none;">+ Nuevo banner</a>
</div>
@if(session('success'))
<div style="background:#f0fdf4;border:1px solid #86efac;color:#166534;padding:12px 16px;border-radius:8px;font-size:13px;margin-bottom:16px;">{{ session('success') }}</div>
@endif
<div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">
<table style="width:100%;border-collapse:collapse;">
<thead style="background:#f9fafb;">
<tr>
<th style="text-align:left;padding:12px 16px;font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase;">Banner</th>
<th style="text-align:center;padding:12px 16px;font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase;">Estado</th>
<th style="text-align:center;padding:12px 16px;font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase;">Orden</th>
<th style="text-align:right;padding:12px 16px;font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase;">Acciones</th>
</tr>
</thead>
<tbody>
@forelse($banners as $banner)
<tr style="border-top:1px solid #f3f4f6;">
<td style="padding:14px 16px;">
<div style="display:flex;align-items:center;gap:12px;">
@if($banner->imagen_path)
<img src="{{ asset('storage/'.$banner->imagen_path) }}" style="width:80px;height:50px;object-fit:cover;border-radius:4px;">
@else
<div style="width:80px;height:50px;background:#f3f4f6;border-radius:4px;"></div>
@endif
<div>
<p style="font-size:13px;font-weight:600;color:#111;margin:0;">{{ $banner->titulo }}</p>
<p style="font-size:12px;color:#6b7280;margin:2px 0 0;">{{ $banner->subtitulo }}</p>
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
<a href="/admin/banners/{{ $banner->id }}/edit" style="display:inline-block;background:#eff6ff;color:#1a56db;border:1px solid #93c5fd;padding:6px 12px;border-radius:6px;font-size:12px;font-weight:600;text-decoration:none;margin-right:6px;">Editar</a>
<form method="POST" action="{{ route('admin.banners.destroy', $banner->id) }}" onsubmit="return confirm('Eliminar?')" style="display:inline-block;">
@csrf
@method('DELETE')
<button type="submit" style="background:#fef2f2;color:#dc2626;border:1px solid #fca5a5;padding:6px 12px;border-radius:6px;font-size:12px;font-weight:600;cursor:pointer;">Eliminar</button>
</form>
</td>
</tr>
@empty
<tr><td colspan="4" style="padding:32px;text-align:center;color:#6b7280;font-size:13px;">No hay banners.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
@endsection
