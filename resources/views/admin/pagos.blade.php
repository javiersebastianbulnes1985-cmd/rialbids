@extends('layouts.app')
@section('content')
<div style="max-width:1100px;margin:0 auto;padding:24px 16px">
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px">
<div><h1 style="font-size:20px;font-weight:700;margin:0">Panel de Pagos y Disputas</h1>
<p style="font-size:12px;color:#6b7280;margin:4px 0 0">Disputas activas y pagos en transito</p></div>
<a href="{{ route('admin.index') }}" style="font-size:13px;color:#6b7280;text-decoration:none">Volver al panel</a>
</div>
@if(count($disputas) > 0)
<div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:10px;padding:20px;margin-bottom:28px">
<h2 style="font-size:15px;font-weight:700;color:#991b1b;margin:0 0 16px">DISPUTAS ACTIVAS ({{ count($disputas) }})</h2>
<table style="width:100%;border-collapse:collapse;font-size:13px">
<thead><tr style="background:#fee2e2"><th style="padding:10px;text-align:left">Subasta</th><th style="padding:10px;text-align:left">Comprador</th><th style="padding:10px;text-align:left">Vendedor</th><th style="padding:10px;text-align:right">Monto</th><th style="padding:10px;text-align:left">Estado</th><th style="padding:10px;text-align:left">Fecha</th><th style="padding:10px;text-align:left">Stripe</th></tr></thead><tbody>
@foreach($disputas as $d)
<tr style="border-bottom:1px solid #fecaca">
<td style="padding:10px"><a href="{{ route('auctions.show', $d->id) }}" style="color:#dc2626;font-weight:600">#{{ $d->id }} {{ $d->title }}</a></td>
<td style="padding:10px">{{ $d->comprador }}<br><small>{{ $d->comprador_email }}</small></td>
<td style="padding:10px">{{ $d->vendedor }}</td>
<td style="padding:10px;text-align:right;font-weight:700">EUR {{ number_format($d->final_price, 2) }}</td>
<td style="padding:10px">{{ strtoupper($d->dispute_status ?? 'ABIERTA') }}</td>
<td style="padding:10px;font-size:12px">{{ $d->disputed_at ? CarbonCarbon::parse($d->disputed_at)->format('d/m/Y H:i') : '-' }}</td>
<td style="padding:10px"><a href="https://dashboard.stripe.com/disputes/{{ $d->dispute_id }}" target="_blank" style="color:#dc2626">Ver en Stripe</a></td>
<td style="padding:10px"><form method="POST" action="{{ route('admin.pagos.liberar', $p->id) }}" style="display:inline">@csrf<button type="submit" onclick="return confirm('¿Liberar pago al vendedor?')" style="font-size:11px;background:#16a34a;color:#fff;padding:4px 8px;border-radius:6px;border:none;cursor:pointer;margin-right:4px">Liberar</button></form><form method="POST" action="{{ route('admin.pagos.reembolsar', $p->id) }}" style="display:inline">@csrf<button type="submit" onclick="return confirm('¿Reembolsar al comprador?')" style="font-size:11px;background:#dc2626;color:#fff;padding:4px 8px;border-radius:6px;border:none;cursor:pointer">Reembolsar</button></form></td></tr>
@endforeach
</tbody></table></div>
@else
<div style="background:#f0fdf4;border:1px solid #86efac;border-radius:10px;padding:16px;margin-bottom:28px">
<p style="margin:0;color:#166534">Sin disputas activas</p></div>
@endif
<div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:20px;margin-bottom:28px">
<h2 style="font-size:15px;font-weight:700;color:#1f2937;margin:0 0 16px">PAGOS EN TRANSITO ({{ count($pendientes) }})</h2>
@if(count($pendientes) > 0)
<table style="width:100%;border-collapse:collapse;font-size:13px">
<thead><tr style="background:#f9fafb"><th style="padding:10px;text-align:left">Subasta</th><th style="padding:10px;text-align:left">Comprador</th><th style="padding:10px;text-align:left">Vendedor</th><th style="padding:10px;text-align:right">Monto</th><th style="padding:10px;text-align:left">Estado</th><th style="padding:10px;text-align:left">Tracking</th><th style="padding:10px;text-align:left">Libera</th><th style="padding:10px;text-align:left">Acciones</th></tr></thead><tbody>
@foreach($pendientes as $p)
<tr style="border-bottom:1px solid #f3f4f6">
<td style="padding:10px"><a href="{{ route('auctions.show', $p->id) }}" style="color:#1d4ed8;font-weight:600">#{{ $p->id }} {{ $p->title }}</a></td>
<td style="padding:10px">
  <strong>{{ $p->comprador }}</strong><br>
  <small style="color:#6b7280">{{ $p->comprador_email ?? '' }}</small>
  @if(!empty($p->comprador_address))
  <br><small style="color:#374151;margin-top:2px;display:block">
    {{ $p->comprador_address }}, {{ $p->comprador_city }} {{ $p->comprador_postal }}<br>
    {{ $p->comprador_country }}
    @if(!empty($p->comprador_phone)) &middot; {{ $p->comprador_phone }}@endif
  </small>
  @else
  <br><small style="color:#ef4444">Sin dirección registrada</small>
  @endif
</td>
<td style="padding:10px">{{ $p->vendedor }}</td>
<td style="padding:10px;text-align:right;font-weight:700">EUR {{ number_format($p->final_price, 2) }}</td>
<td style="padding:10px">{{ strtoupper($p->status) }}</td>
<td style="padding:10px;font-size:12px">@if($p->tracking_number){{ $p->tracking_carrier }} - {{ $p->tracking_number }}@else<span style="color:#ef4444">Sin tracking</span>@endif</td>
<td style="padding:10px;font-size:12px">@if($p->payment_released_at)<span style="color:#16a34a">Liberado</span>@elseif($p->payment_release_scheduled_at){{ CarbonCarbon::parse($p->payment_release_scheduled_at)->diffForHumans() }}@else-@endif</td>
<td style="padding:10px"><form method="POST" action="{{ route('admin.pagos.liberar', $p->id) }}" style="display:inline">@csrf<button type="submit" onclick="return confirm('¿Liberar pago al vendedor?')" style="font-size:11px;background:#16a34a;color:#fff;padding:4px 8px;border-radius:6px;border:none;cursor:pointer;margin-right:4px">Liberar</button></form><form method="POST" action="{{ route('admin.pagos.reembolsar', $p->id) }}" style="display:inline">@csrf<button type="submit" onclick="return confirm('¿Reembolsar al comprador?')" style="font-size:11px;background:#dc2626;color:#fff;padding:4px 8px;border-radius:6px;border:none;cursor:pointer">Reembolsar</button></form></td></tr>
@endforeach
</tbody></table>
@else
<p style="font-size:13px;color:#6b7280;margin:0">No hay pagos en transito.</p>
@endif
</div>
</div>

@if(isset($disputasComprador) && count($disputasComprador) > 0)
<div style="background:#fff;border:1px solid #fca5a5;border-radius:12px;padding:20px;margin-bottom:24px">
<h2 style="font-size:15px;font-weight:700;color:#991b1b;margin:0 0 16px">DISPUTAS DE COMPRADORES ({{ count($disputasComprador) }})</h2>
@foreach($disputasComprador as $dc)
<div style="border:1px solid #e5e7eb;border-radius:8px;padding:14px;margin-bottom:12px">
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
<span style="font-size:14px;font-weight:700;color:#111827">{{ $dc->lote_title ?? ('Lote #'.$dc->auction_id) }}</span>
<span style="font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;background:#fef9ec;color:#8a6820">{{ strtoupper(str_replace('_',' ',$dc->status)) }}</span>
</div>
<p style="font-size:12px;color:#6b7280;margin:0 0 6px">Comprador: <strong>{{ $dc->comprador }}</strong> ({{ $dc->comprador_email }}) &middot; Vendedor: <strong>{{ $dc->vendedor }}</strong> &middot; EUR {{ number_format($dc->final_price ?? 0, 2) }}</p>
<p style="font-size:12px;color:#374151;margin:0 0 6px"><strong>Motivo:</strong> {{ $dc->reason }}</p>
<p style="font-size:13px;color:#374151;background:#f9fafb;padding:10px;border-radius:6px;margin:0 0 8px">{{ $dc->description }}</p>
@if($dc->photo_path)<a href="{{ asset('storage/'.$dc->photo_path) }}" target="_blank" style="font-size:12px;color:#1a3a6b">Ver foto adjunta</a> &middot; @endif
<a href="{{ route('auctions.show', $dc->auction_id) }}" target="_blank" style="font-size:12px;color:#1a3a6b">Ver lote</a>
@if(!in_array($dc->status, ['resuelta_comprador','resuelta_vendedor','cerrada']))
<div style="margin-top:12px;padding-top:12px;border-top:1px solid #f3f4f6;display:flex;gap:8px;flex-wrap:wrap">
<form method="POST" action="{{ route('admin.disputes.resolver', $dc->id) }}" style="display:inline">@csrf<input type="hidden" name="accion" value="comprador"><button type="submit" onclick="return confirm('ATENCION - ACCION CON DINERO REAL\n\nVas a REEMBOLSAR al comprador {{ $dc->comprador }}.\nLote: {{ $dc->lote_title }}\nMonto: EUR {{ number_format($dc->final_price ?? 0, 2) }}\n\nEsta accion mueve plata en Stripe y no se puede deshacer.\n\nConfirmas?')" style="font-size:11px;background:#dc2626;color:#fff;padding:5px 12px;border-radius:6px;border:none;cursor:pointer;font-weight:600">Dar razon al comprador (reembolsar)</button></form>
<form method="POST" action="{{ route('admin.disputes.resolver', $dc->id) }}" style="display:inline">@csrf<input type="hidden" name="accion" value="vendedor"><button type="submit" onclick="return confirm('ATENCION - ACCION CON DINERO REAL\n\nVas a LIBERAR el pago al vendedor {{ $dc->vendedor }}.\nLote: {{ $dc->lote_title }}\nMonto: EUR {{ number_format($dc->final_price ?? 0, 2) }}\n\nEsta accion transfiere plata a la cuenta del vendedor y no se puede deshacer.\n\nConfirmas?')" style="font-size:11px;background:#16a34a;color:#fff;padding:5px 12px;border-radius:6px;border:none;cursor:pointer;font-weight:600">Dar razon al vendedor (liberar)</button></form>
<form method="POST" action="{{ route('admin.disputes.resolver', $dc->id) }}" style="display:inline">@csrf<input type="hidden" name="accion" value="revision"><button type="submit" style="font-size:11px;background:#fff;color:#374151;padding:5px 12px;border-radius:6px;border:1px solid #d1d5db;cursor:pointer;font-weight:600">Marcar en revision</button></form>
</div>
@else
<div style="margin-top:10px;font-size:11px;color:#16a34a;font-weight:600">Resuelta @if($dc->resolved_at)&middot; {{ \Carbon\Carbon::parse($dc->resolved_at)->format('d/m/Y') }}@endif</div>
@endif
</div>
@endforeach
</div>
@endif

@endsection
