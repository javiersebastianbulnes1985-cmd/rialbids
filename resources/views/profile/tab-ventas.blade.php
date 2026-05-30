<div id="tab-ventas" class="tab-panel">
@if(isset($ventas) && $ventas->isEmpty())
<div style="background:#fff;border:2px dashed #e5e7eb;border-radius:20px;padding:60px;text-align:center">
<div style="font-size:56px;margin-bottom:16px">📦</div>
<p style="font-size:18px;font-weight:700;color:#111;margin:0 0 8px">Todavía no tenés ventas</p>
<p style="font-size:14px;color:#9ca3af;margin:0">Cuando vendas un lote aparecerá acá</p>
</div>
@else
@foreach($ventas ?? [] as $venta)
<div style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;margin-bottom:16px;padding:20px">
<div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px">
<div>
<p style="font-size:15px;font-weight:700;color:#111;margin:0">{{ $venta->title }}</p>
<p style="font-size:12px;color:#9ca3af;margin:4px 0 0">Lote #{{ str_pad($venta->id,4,'0',STR_PAD_LEFT) }} — Comprador: {{ $venta->winner->name ?? '—' }}</p>
</div>
<p style="font-size:20px;font-weight:800;color:#111;margin:0">€{{ number_format($venta->final_price ?? $venta->current_price,0,',','.') }}</p>
</div>
@if($venta->status === 'paid')
<div style="background:#fefce8;border:1px solid #fde68a;border-radius:12px;padding:16px;margin-bottom:12px">
<p style="font-size:13px;font-weight:700;color:#92400e;margin:0 0 12px">⏳ Pendiente de envío — cargá el tracking</p>
@if(session('success'))
<div style="background:#d1fae5;color:#065f46;padding:10px 16px;border-radius:8px;margin-bottom:12px;font-size:13px;font-weight:600">{{ session('success') }}</div>
@endif
<form method="POST" action="{{ route('profile.tracking', $venta->id) }}">
@csrf
<div style="display:flex;gap:10px;flex-wrap:wrap">
<select name="tracking_carrier" required style="flex:1;min-width:140px;padding:8px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:13px">
<option value="">Transportista</option>
<option value="Correos">Correos</option>
<option value="DHL">DHL</option>
<option value="UPS">UPS</option>
<option value="FedEx">FedEx</option>
<option value="GLS">GLS</option>
<option value="SEUR">SEUR</option>
<option value="Royal Mail">Royal Mail</option>
<option value="DPD">DPD</option>
<option value="CTT">CTT</option>
<option value="Otro">Otro</option>
</select>
<input type="text" name="tracking_number" placeholder="Número de tracking" required style="flex:2;min-width:160px;padding:8px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:13px">
<button type="submit" style="background:#1a56db;color:#fff;border:none;padding:8px 20px;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer">Confirmar envío</button>
</div>
</form>
</div>
@elseif($venta->status === 'shipped')
<div style="background:#eff6ff;border-radius:12px;padding:14px 16px;margin-bottom:12px">
<p style="font-size:13px;font-weight:700;color:#1d4ed8;margin:0 0 4px">📦 Enviado</p>
<p style="font-size:12px;color:#3b82f6;margin:0">{{ $venta->tracking_carrier }} — {{ $venta->tracking_number }}</p>
<p style="font-size:11px;color:#93c5fd;margin:4px 0 0">Despachado el {{ $venta->shipped_at ? $venta->shipped_at->format('d/m/Y H:i') : '—' }}</p>
</div>
@elseif(in_array($venta->status,['delivered','completed']))
<div style="background:#d1fae5;border-radius:12px;padding:14px 16px;margin-bottom:12px">
<p style="font-size:13px;font-weight:700;color:#065f46;margin:0">✅ Entregado — pago liberado</p>
</div>
@endif
</div>
@endforeach
@endif
</div>

