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
<td style="padding:10px"><a href="https://dashboard.stripe.com/payments" target="_blank" style="font-size:11px;background:#1d4ed8;color:#fff;padding:4px 8px;border-radius:6px;text-decoration:none">Ver Stripe</a></td></tr>
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
<td style="padding:10px">{{ $p->comprador }}</td>
<td style="padding:10px">{{ $p->vendedor }}</td>
<td style="padding:10px;text-align:right;font-weight:700">EUR {{ number_format($p->final_price, 2) }}</td>
<td style="padding:10px">{{ strtoupper($p->status) }}</td>
<td style="padding:10px;font-size:12px">@if($p->tracking_number){{ $p->tracking_carrier }} - {{ $p->tracking_number }}@else<span style="color:#ef4444">Sin tracking</span>@endif</td>
<td style="padding:10px;font-size:12px">@if($p->payment_released_at)<span style="color:#16a34a">Liberado</span>@elseif($p->payment_release_scheduled_at){{ CarbonCarbon::parse($p->payment_release_scheduled_at)->diffForHumans() }}@else-@endif</td>
<td style="padding:10px"><a href="https://dashboard.stripe.com/payments" target="_blank" style="font-size:11px;background:#1d4ed8;color:#fff;padding:4px 8px;border-radius:6px;text-decoration:none">Ver Stripe</a></td></tr>
@endforeach
</tbody></table>
@else
<p style="font-size:13px;color:#6b7280;margin:0">No hay pagos en transito.</p>
@endif
</div>
</div>
@endsection
