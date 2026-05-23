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
<div style="background:#f5f3ff;border:1px solid #c4b5fd;border-radius:10px;padding:18px">
<p style="font-size:11px;font-weight:600;color:#5b21b6;text-transform:uppercase;margin:0 0 8px">Total Gastos</p>
<p style="font-size:26px;font-weight:700;color:#5b21b6;margin:0">€{{ number_format($totalGastos, 2) }}</p>
<p style="font-size:11px;color:#7c3aed;margin:4px 0 0">Este mes</p></div>
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

<div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;margin-bottom:24px">
<div style="padding:16px 20px;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;justify-content:space-between">
<h2 style="font-size:14px;font-weight:700;margin:0">💰 Gastos</h2>
<span style="font-size:12px;color:#6b7280">Balance: <strong style="color:{{ ($resumen->comisiones_cobradas ?? 0) - $totalGastos >= 0 ? "#16a34a" : "#dc2626" }}">€{{ number_format(($resumen->comisiones_cobradas ?? 0) - $totalGastos, 2) }}</strong></span>
</div>
<div style="padding:20px">
<form method="POST" action="{{ route("admin.gastos.store") }}" style="display:grid;grid-template-columns:2fr 1fr 1fr 2fr auto;gap:12px;align-items:end;margin-bottom:20px">
@csrf
<div><label style="font-size:11px;font-weight:600;color:#6b7280;display:block;margin-bottom:4px">CONCEPTO</label>
<input name="concepto" placeholder="Meta Ads, Hosting..." required style="width:100%;padding:8px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px"></div>
<div><label style="font-size:11px;font-weight:600;color:#6b7280;display:block;margin-bottom:4px">MONTO €</label>
<input name="monto" type="number" step="0.01" placeholder="0.00" required style="width:100%;padding:8px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px"></div>
<div><label style="font-size:11px;font-weight:600;color:#6b7280;display:block;margin-bottom:4px">MES</label>
<input name="mes" type="month" value="{{ date("Y-m") }}" required style="width:100%;padding:8px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px"></div>
<div><label style="font-size:11px;font-weight:600;color:#6b7280;display:block;margin-bottom:4px">NOTAS</label>
<input name="notas" placeholder="Opcional..." style="width:100%;padding:8px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px"></div>
<button type="submit" style="background:#1a56db;color:#fff;border:none;padding:8px 16px;border-radius:6px;font-size:13px;font-weight:600;cursor:pointer;white-space:nowrap">+ Agregar</button>
</form>
@if($gastos->count() > 0)
<table style="width:100%;border-collapse:collapse">
<thead><tr style="background:#f9fafb">
<th style="text-align:left;padding:10px 12px;font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase">Concepto</th>
<th style="text-align:left;padding:10px 12px;font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase">Mes</th>
<th style="text-align:right;padding:10px 12px;font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase">Monto</th>
<th style="text-align:left;padding:10px 12px;font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase">Notas</th>
<th style="padding:10px 12px"></th>
</tr></thead><tbody>
@foreach($gastos as $g)
<tr style="border-top:1px solid #f3f4f6">
<td style="padding:10px 12px;font-size:13px;font-weight:600">{{ $g->concepto }}</td>
<td style="padding:10px 12px;font-size:13px;color:#6b7280">{{ $g->mes }}</td>
<td style="padding:10px 12px;font-size:13px;text-align:right;color:#dc2626;font-weight:600">€{{ number_format($g->monto, 2) }}</td>
<td style="padding:10px 12px;font-size:13px;color:#9ca3af">{{ $g->notas ?? "---" }}</td>
<td style="padding:10px 12px;text-align:right">
<form method="POST" action="{{ route("admin.gastos.destroy", $g->id) }}" style="display:inline">@csrf @method("DELETE")
<button type="submit" style="background:#fee2e2;color:#dc2626;border:none;padding:4px 10px;border-radius:4px;font-size:11px;cursor:pointer">Eliminar</button>
</form></td>
</tr>
@endforeach
</tbody></table>
@else
<p style="color:#9ca3af;font-size:13px;text-align:center;padding:20px">No hay gastos registrados</p>
@endif
</div>
</div>

</div>
@endsection
