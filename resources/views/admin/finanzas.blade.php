@extends('layouts.app')
@section('content')
<div style="max-width:1100px;margin:0 auto;padding:24px 16px">
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px">
<div><h1 style="font-size:20px;font-weight:700;margin:0">Panel Financiero</h1>
<p style="font-size:12px;color:#6b7280;margin:4px 0 0">Resumen de ingresos, escrow y alertas</p></div>
<a href="{{ route('admin.index') }}" style="font-size:13px;color:#6b7280;text-decoration:none">← Volver al panel</a>
</div>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:28px">
<div style="background:#f0fdf4;border:1px solid #86efac;border-radius:10px;padding:18px">
<p style="font-size:11px;font-weight:600;color:#166534;text-transform:uppercase;margin:0 0 8px">Comisiones cobradas</p>
<p style="font-size:26px;font-weight:700;color:#166534;margin:0">€{{ number_format($resumen->comisiones_cobradas ?? 0, 2) }}</p>
<p style="font-size:11px;color:#16a34a;margin:4px 0 0">Ventas completadas</p></div>
<div style="background:#fefce8;border:1px solid #fde047;border-radius:10px;padding:18px">
<p style="font-size:11px;font-weight:600;color:#854d0e;text-transform:uppercase;margin:0 0 8px">En escrow</p>
<p style="font-size:26px;font-weight:700;color:#854d0e;margin:0">€{{ number_format($resumen->escrow_total ?? 0, 2) }}</p>
<p style="font-size:11px;color:#a16207;margin:4px 0 0">{{ $resumen->lotes_escrow ?? 0 }} lotes retenidos</p></div>
<div style="background:#eff6ff;border:1px solid #93c5fd;border-radius:10px;padding:18px">
<p style="font-size:11px;font-weight:600;color:#1e40af;text-transform:uppercase;margin:0 0 8px">Volumen completado</p>
<p style="font-size:26px;font-weight:700;color:#1e40af;margin:0">€{{ number_format($resumen->volumen_completado ?? 0, 2) }}</p>
<p style="font-size:11px;color:#2563eb;margin:4px 0 0">Total transacciones</p></div>
<div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:10px;padding:18px">
<p style="font-size:11px;font-weight:600;color:#991b1b;text-transform:uppercase;margin:0 0 8px">Sin pagar</p>
<p style="font-size:26px;font-weight:700;color:#991b1b;margin:0">{{ $resumen->sin_pagar ?? 0 }}</p>
<p style="font-size:11px;color:#dc2626;margin:4px 0 0">Ganadores que no pagaron</p></div>
</div>
<div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;margin-bottom:24px">
<div style="padding:16px 20px;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;justify-content:space-between">
<h2 style="font-size:14px;font-weight:700;margin:0">Pagos en escrow</h2>
<span style="font-size:11px;background:#fefce8;color:#854d0e;padding:3px 10px;border-radius:20px;font-weight:600">{{ count($escrow) }} lotes</span></div>
@if(count($escrow) > 0)
<table style="width:100%;border-collapse:collapse">
<thead style="background:#f9fafb"><tr>
<th style="text-align:left;padding:10px 16px;font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase">Lote</th>
<th style="text-align:left;padding:10px 16px;font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase">Vendedor</th>
<th style="text-align:left;padding:10px 16px;font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase">Comprador</th>
<th style="text-align:right;padding:10px 16px;font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase">Precio</th>
<th style="text-align:right;padding:10px 16px;font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase">Comision</th>
<th style="text-align:center;padding:10px 16px;font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase">Estado</th>
</tr></thead><tbody>
@foreach($escrow as $row)
<tr style="border-top:1px solid #f3f4f6">
<td style="padding:12px 16px;font-size:13px"><a href="{{ route('auctions.show',$row->id) }}" style="color:#1a56db;text-decoration:none;font-weight:600">#{{ str_pad($row->id,4,'0',STR_PAD_LEFT) }}</a><br><span style="font-size:11px;color:#6b7280">{{ Str::limit($row->title,30) }}</span></td>
<td style="padding:12px 16px;font-size:13px">{{ $row->vendedor ?? '---' }}</td>
<td style="padding:12px 16px;font-size:13px">{{ $row->comprador ?? '---' }}</td>
<td style="padding:12px 16px;font-size:13px;text-align:right;font-weight:600">€{{ number_format($row->final_price,2) }}</td>
<td style="padding:12px 16px;font-size:13px;text-align:right;color:#16a34a;font-weight:600">€{{ number_format($row->final_price*$row->commission_rate/100+3,2) }}</td>
<td style="padding:12px 16px;text-align:center">
@if($row->status==='paid')<span style="background:#fefce8;color:#854d0e;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">PAGADO</span>
@else<span style="background:#eff6ff;color:#1e40af;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">ENVIADO</span>@endif
</td></tr>
@endforeach
</tbody></table>
@else<p style="padding:20px;color:#6b7280;font-size:13px;text-align:center">No hay pagos en escrow</p>@endif
</div>
@if(count($sinPagar) > 0)
<div style="background:#fff;border:1px solid #fca5a5;border-radius:10px;overflow:hidden;margin-bottom:24px">
<div style="padding:16px 20px;border-bottom:1px solid #fca5a5;background:#fef2f2">
<h2 style="font-size:14px;font-weight:700;margin:0;color:#991b1b">Ganadores que no pagaron</h2></div>
<table style="width:100%;border-collapse:collapse">
<thead style="background:#fef2f2"><tr>
<th style="text-align:left;padding:10px 16px;font-size:11px;color:#991b1b;font-weight:600;text-transform:uppercase">Lote</th>
<th style="text-align:left;padding:10px 16px;font-size:11px;color:#991b1b;font-weight:600;text-transform:uppercase">Ganador</th>
<th style="text-align:left;padding:10px 16px;font-size:11px;color:#991b1b;font-weight:600;text-transform:uppercase">Email</th>
<th style="text-align:right;padding:10px 16px;font-size:11px;color:#991b1b;font-weight:600;text-transform:uppercase">Precio</th>
<th style="text-align:right;padding:10px 16px;font-size:11px;color:#991b1b;font-weight:600;text-transform:uppercase">Termino</th>
</tr></thead><tbody>
@foreach($sinPagar as $row)
<tr style="border-top:1px solid #fee2e2">
<td style="padding:12px 16px;font-size:13px"><a href="{{ route('auctions.show',$row->id) }}" style="color:#dc2626;text-decoration:none;font-weight:600">#{{ str_pad($row->id,4,'0',STR_PAD_LEFT) }}</a><br><span style="font-size:11px;color:#6b7280">{{ Str::limit($row->title,30) }}</span></td>
<td style="padding:12px 16px;font-size:13px">{{ $row->comprador ?? '---' }}</td>
<td style="padding:12px 16px;font-size:13px;color:#6b7280">{{ $row->comprador_email ?? '---' }}</td>
<td style="padding:12px 16px;font-size:13px;text-align:right;font-weight:600">€{{ number_format($row->final_price,2) }}</td>
<td style="padding:12px 16px;font-size:13px;text-align:right;color:#6b7280">{{ $row->finished_at ? \Carbon\Carbon::parse($row->finished_at)->diffForHumans() : '---' }}</td>
</tr>
@endforeach
</tbody></table></div>
@endif
<div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden">
<div style="padding:16px 20px;border-bottom:1px solid #e5e7eb">
<h2 style="font-size:14px;font-weight:700;margin:0">Historial - Pagos liberados</h2></div>
@if(count($completados) > 0)
<table style="width:100%;border-collapse:collapse">
<thead style="background:#f9fafb"><tr>
<th style="text-align:left;padding:10px 16px;font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase">Lote</th>
<th style="text-align:left;padding:10px 16px;font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase">Vendedor</th>
<th style="text-align:left;padding:10px 16px;font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase">Comprador</th>
<th style="text-align:right;padding:10px 16px;font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase">Precio</th>
<th style="text-align:right;padding:10px 16px;font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase">Comision</th>
<th style="text-align:right;padding:10px 16px;font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase">Liberado</th>
</tr></thead><tbody>
@foreach($completados as $row)
<tr style="border-top:1px solid #f3f4f6">
<td style="padding:12px 16px;font-size:13px"><a href="{{ route('auctions.show',$row->id) }}" style="color:#1a56db;text-decoration:none;font-weight:600">#{{ str_pad($row->id,4,'0',STR_PAD_LEFT) }}</a><br><span style="font-size:11px;color:#6b7280">{{ Str::limit($row->title,30) }}</span></td>
<td style="padding:12px 16px;font-size:13px">{{ $row->vendedor ?? '---' }}</td>
<td style="padding:12px 16px;font-size:13px">{{ $row->comprador ?? '---' }}</td>
<td style="padding:12px 16px;font-size:13px;text-align:right;font-weight:600">€{{ number_format($row->final_price,2) }}</td>
<td style="padding:12px 16px;font-size:13px;text-align:right;color:#16a34a;font-weight:600">€{{ number_format($row->final_price*$row->commission_rate/100+3,2) }}</td>
<td style="padding:12px 16px;font-size:13px;text-align:right;color:#6b7280">{{ $row->payment_released_at ? \Carbon\Carbon::parse($row->payment_released_at)->format('d/m/Y') : '---' }}</td>
</tr>
@endforeach
</tbody></table>
@else<p style="padding:20px;color:#6b7280;font-size:13px;text-align:center">Aun no hay ventas completadas</p>@endif
</div></div>
@endsection
