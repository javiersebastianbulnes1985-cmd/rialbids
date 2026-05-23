@extends('layouts.app')
@section('content')
<style>
.vd-wrap{max-width:1100px;margin:40px auto;padding:0 20px}
.vd-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:12px}
.vd-title{font-size:22px;font-weight:700;color:#111827;margin:0}
.btn-new{padding:10px 20px;background:#111827;color:#fff;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px}
.stats{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:24px}
.stat{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:16px;text-align:center}
.stat-n{font-size:26px;font-weight:700;color:#111827;margin:0}
.stat-l{font-size:11px;color:#6b7280;margin-top:4px}
.alert-stripe{background:#fffbeb;border:1px solid #fbbf24;color:#92400e;padding:14px 18px;border-radius:10px;margin-bottom:20px;font-size:13px;display:flex;align-items:center;gap:10px}
.alert-success{background:#f0fdf4;border:1px solid #86efac;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:13px}
.alert-error{background:#fef2f2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:13px}
.card{background:#fff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;margin-bottom:20px}
.card-header{padding:16px 20px;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;justify-content:space-between}
.card-title{font-size:14px;font-weight:700;color:#111827}
.table{width:100%;border-collapse:collapse}
.table th{padding:10px 16px;text-align:left;font-size:11px;font-weight:600;color:#6b7280;text-transform:uppercase;border-bottom:1px solid #e5e7eb;white-space:nowrap}
.table td{padding:12px 16px;border-bottom:1px solid #f3f4f6;vertical-align:middle;font-size:13px}
.table tr:last-child td{border-bottom:none}
.table tr:hover td{background:#f9fafb}
.badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600}
.lot-img{width:44px;height:44px;border-radius:8px;object-fit:cover;background:#f3f4f6;flex-shrink:0}
.btn{display:inline-flex;align-items:center;padding:5px 12px;border-radius:6px;font-size:12px;font-weight:600;text-decoration:none;border:none;cursor:pointer;white-space:nowrap}
.btn-edit{background:#eff6ff;color:#1d4ed8}
.btn-ship{background:#111827;color:#fff}
.btn-view{background:#f3f4f6;color:#374151}
.cancelled-banner{background:#fef2f2;border:1px solid #fca5a5;border-radius:8px;padding:10px 14px;margin-top:6px;font-size:12px;color:#991b1b}
</style>

<div class="vd-wrap">
  <div class="vd-header">
    <div>
      <h1 class="vd-title">Mi Panel de Vendedor</h1>
      <p style="font-size:13px;color:#6b7280;margin:4px 0 0">Bienvenido, {{ auth()->user()->name }}</p>
    </div>
    <a href="{{ route('vendor.create') }}" class="btn-new">+ Nuevo lote</a>
  </div>

  {{-- Stats --}}
  @php
    $ganancias = $auctions->whereIn('status',['paid','shipped','delivered','completed'])->sum('final_price');
    $comisiones = $ganancias * 0.09 + ($auctions->whereIn('status',['paid','shipped','delivered','completed'])->count() * 3);
    $neto = $ganancias - $comisiones;
  @endphp
  <div class="stats">
    <div class="stat">
      <p class="stat-n">{{ $stats['total'] }}</p>
      <p class="stat-l">Total lotes</p>
    </div>
    <div class="stat" style="border-color:#fbbf24">
      <p class="stat-n" style="color:#d97706">{{ $stats['pendiente'] }}</p>
      <p class="stat-l">Pendientes</p>
    </div>
    <div class="stat" style="border-color:#86efac">
      <p class="stat-n" style="color:#16a34a">{{ $stats['activo'] }}</p>
      <p class="stat-l">Activos</p>
    </div>
    <div class="stat">
      <p class="stat-n" style="color:#6b7280">{{ $stats['finalizado'] }}</p>
      <p class="stat-l">Finalizados</p>
    </div>
    <div class="stat" style="border-color:#a5b4fc">
      <p class="stat-n" style="color:#4f46e5">€{{ number_format($neto,0,',','.') }}</p>
      <p class="stat-l">Ganancias netas</p>
    </div>
  </div>

  {{-- Alertas --}}
  @if(session('success'))
    <div class="alert-success">✓ {{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert-error">✗ {{ session('error') }}</div>
  @endif

  {{-- Stripe --}}
  @if(!auth()->user()->stripe_onboarding_complete)
  <div class="alert-stripe">
    <span style="font-size:20px">⚠️</span>
    <div>
      <strong>Tu cuenta de pagos no está configurada.</strong><br>
      <span style="font-size:12px">Necesitás conectar tu cuenta Stripe para recibir pagos de tus ventas.</span>
      <a href="{{ route('vendor.stripe.onboarding') }}" style="display:inline-block;margin-top:8px;background:#f59e0b;color:#fff;padding:6px 14px;border-radius:6px;font-size:12px;font-weight:700;text-decoration:none;">Configurar cuenta →</a>
    </div>
  </div>
  @endif

  {{-- Lotes rechazados --}}
  @php $rechazados = $auctions->where('status','cancelled'); @endphp
  @if($rechazados->count() > 0)
  <div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:10px;padding:16px 20px;margin-bottom:20px;">
    <p style="font-size:13px;font-weight:700;color:#991b1b;margin:0 0 8px">❌ Lotes rechazados/cancelados ({{ $rechazados->count() }})</p>
    @foreach($rechazados as $lot)
    <div style="font-size:12px;color:#7f1d1d;padding:6px 0;border-top:1px solid #fecaca;">
      <strong>{{ $lot->title }}</strong> — {{ $lot->rejection_reason ?? 'Sin motivo especificado' }}
    </div>
    @endforeach
  </div>
  @endif

  {{-- Tabla lotes --}}
  @if($auctions->where('status','!=','cancelled')->isEmpty())
    <div class="card">
      <div style="text-align:center;padding:60px 0;color:#9ca3af;">
        <p style="font-size:16px;margin-bottom:8px">No tenés lotes todavía.</p>
        <a href="{{ route('vendor.create') }}" style="color:#1a56db;font-size:13px;font-weight:600;">Crear tu primer lote →</a>
      </div>
    </div>
  @else
  <div class="card">
    <div class="card-header">
      <span class="card-title">📦 Mis Lotes</span>
      <span style="font-size:12px;color:#6b7280">{{ $auctions->where('status','!=','cancelled')->count() }} lotes</span>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>Lote</th>
          <th>Estado</th>
          <th style="text-align:right">Precio actual</th>
          <th style="text-align:center">Pujas</th>
          <th style="text-align:right">Cierra</th>
          <th style="text-align:center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($auctions->where('status','!=','cancelled') as $lot)
        @php
          $img = !empty($lot->image_path) ? (str_starts_with($lot->image_path,'http') ? $lot->image_path : asset('storage/'.$lot->image_path)) : null;
          $cp = $lot->current_price ?? $lot->base_price ?? 0;
          $statusMap = [
            'active'    => ['bg'=>'#d1fae5','color'=>'#065f46','label'=>'Activo'],
            'pending'   => ['bg'=>'#fef3c7','color'=>'#92400e','label'=>'En revisión'],
            'finished'  => ['bg'=>'#e5e7eb','color'=>'#374151','label'=>'Finalizado'],
            'paid'      => ['bg'=>'#dbeafe','color'=>'#1e40af','label'=>'Pagado ✓'],
            'shipped'   => ['bg'=>'#d1fae5','color'=>'#065f46','label'=>'Enviado 📦'],
            'delivered' => ['bg'=>'#d1fae5','color'=>'#065f46','label'=>'Entregado ✓'],
            'completed' => ['bg'=>'#d1fae5','color'=>'#15803d','label'=>'Completado ✓'],
          ];
          $sc = $statusMap[$lot->status] ?? ['bg'=>'#f3f4f6','color'=>'#6b7280','label'=>ucfirst($lot->status)];
        @endphp
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:12px">
              @if($img)
                <img src="{{ $img }}" class="lot-img">
              @else
                <div class="lot-img" style="display:flex;align-items:center;justify-content:center;font-size:20px">📷</div>
              @endif
              <div>
                <p style="font-size:13px;font-weight:600;color:#111827;margin:0">{{ Str::limit($lot->title,45) }}</p>
                <p style="font-size:11px;color:#9ca3af;margin:2px 0 0">Lote #{{ str_pad($lot->id,4,'0',STR_PAD_LEFT) }}</p>
              </div>
            </div>
          </td>
          <td>
            <span style="background:{{ $sc['bg'] }};color:{{ $sc['color'] }};font-size:11px;font-weight:600;padding:4px 10px;border-radius:20px;">
              {{ $sc['label'] }}
            </span>
            @if($lot->status === 'pending')
            <p style="font-size:11px;color:#9ca3af;margin:4px 0 0">Revisión en 24-48h</p>
            @endif
          </td>
          <td style="text-align:right;font-size:14px;font-weight:700;color:{{ $lot->total_bids>0?'#16a34a':'#111827' }}">
            €{{ number_format($cp,0,',','.') }}
          </td>
          <td style="text-align:center;font-size:13px;color:#6b7280">{{ $lot->total_bids ?? 0 }}</td>
          <td style="text-align:right;font-size:12px;color:#6b7280">
            @if($lot->end_time)
              {{ \Carbon\Carbon::parse($lot->end_time)->format('d/m/Y H:i') }}
            @else — @endif
          </td>
          <td style="text-align:center">
            <div style="display:flex;gap:6px;justify-content:center;flex-wrap:wrap">
              @if($lot->status === 'active')
                <a href="{{ route('auctions.show',$lot->id) }}" class="btn btn-view" target="_blank">Ver</a>
              @endif
              @if($lot->status === 'pending')
                <a href="{{ route('vendor.edit',$lot->id) }}" class="btn btn-edit">✏️ Editar</a>
              @endif
              @if($lot->status === 'paid')
                <form method="POST" action="{{ route('vendor.auctions.ship',$lot->id) }}" style="display:flex;gap:4px;align-items:center">
                  @csrf
                  <input type="text" name="tracking_number" placeholder="Nº tracking" required
                    style="border:1px solid #d1d5db;border-radius:6px;padding:4px 8px;font-size:12px;width:120px;">
                  <button type="submit" class="btn btn-ship">📦 Enviado</button>
                </form>
              @elseif($lot->status === 'shipped')
                <span style="font-size:12px;color:#059669">📦 {{ $lot->tracking_number }}</span>
              @elseif(!in_array($lot->status,['active','pending','paid','shipped']))
                <span style="font-size:12px;color:#9ca3af">—</span>
              @endif
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif

  {{-- Historial ganancias --}}
  @php $vendidos = $auctions->whereIn('status',['paid','shipped','delivered','completed']); @endphp
  @if($vendidos->count() > 0)
  <div class="card">
    <div class="card-header"><span class="card-title">💰 Historial de ventas</span></div>
    <table class="table">
      <thead><tr>
        <th>Lote</th>
        <th style="text-align:right">Precio venta</th>
        <th style="text-align:right">Comisión (9%+€3)</th>
        <th style="text-align:right">Tu ganancia</th>
        <th>Estado</th>
      </tr></thead>
      <tbody>
      @foreach($vendidos as $lot)
      @php
        $precio = $lot->final_price ?? $lot->current_price ?? 0;
        $comision = ($precio * 0.09) + 3;
        $ganancia = $precio - $comision;
      @endphp
      <tr>
        <td style="font-weight:600">{{ Str::limit($lot->title,40) }}</td>
        <td style="text-align:right;font-weight:700;color:#111">€{{ number_format($precio,2,',','.') }}</td>
        <td style="text-align:right;color:#ef4444">-€{{ number_format($comision,2,',','.') }}</td>
        <td style="text-align:right;font-weight:700;color:#16a34a">€{{ number_format($ganancia,2,',','.') }}</td>
        <td><span style="font-size:11px;background:#d1fae5;color:#065f46;padding:3px 8px;border-radius:20px;font-weight:600">{{ ucfirst($lot->status) }}</span></td>
      </tr>
      @endforeach
      <tr style="background:#f9fafb">
        <td colspan="2" style="font-weight:700;color:#111">Total</td>
        <td style="text-align:right;font-weight:700;color:#ef4444">-€{{ number_format($comisiones,2,',','.') }}</td>
        <td style="text-align:right;font-weight:700;color:#16a34a;font-size:15px">€{{ number_format($neto,2,',','.') }}</td>
        <td></td>
      </tr>
      </tbody>
    </table>
  </div>
  @endif

</div>
@endsection
