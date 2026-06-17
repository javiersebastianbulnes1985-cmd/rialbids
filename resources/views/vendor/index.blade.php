@extends('layouts.app')
@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&display=swap');
:root{--gold:#c9a84c;--gold-dark:#8a6820;--gold-light:#f0e8d4;--cream:#f8f4ed;--cream-dark:#e0d8c8;--ink:#1a1207;--ink-light:#8a7a5a}
.vd-body{background:var(--cream);min-height:100vh;padding:40px 20px}
.vd-wrap{max-width:1100px;margin:0 auto}
.vd-header-card{background:#fff;border:1px solid var(--cream-dark);border-radius:12px;padding:24px 28px;margin-bottom:20px;display:flex;align-items:flex-start;gap:20px;flex-wrap:wrap}
.vd-avatar{width:60px;height:60px;border-radius:50%;background:var(--ink);display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:500;color:var(--gold);font-family:'Playfair Display',Georgia,serif;flex-shrink:0;overflow:hidden}
.vd-avatar img{width:100%;height:100%;object-fit:cover}
.vd-name{font-family:'Playfair Display',Georgia,serif;font-size:20px;font-weight:500;color:var(--ink);margin:0}
.vd-since{font-size:11px;color:var(--ink-light);margin-top:3px;letter-spacing:.05em}
.badge-verified{display:inline-flex;align-items:center;gap:4px;background:var(--gold-light);border:1px solid var(--gold);color:var(--gold-dark);font-size:10px;font-weight:600;padding:2px 10px;border-radius:20px;margin-left:8px;letter-spacing:.04em}
.vd-bio{font-size:13px;color:#5a4f3a;margin-top:8px;max-width:580px;line-height:1.6}
.btn-new{padding:10px 22px;background:var(--ink);color:var(--gold);border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;letter-spacing:.04em;white-space:nowrap;border:none;cursor:pointer}
.btn-new:hover{background:#2d2010}
.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
@media(max-width:700px){.stats{grid-template-columns:repeat(2,1fr)}}
.stat{background:#fff;border:1px solid var(--cream-dark);border-radius:10px;padding:16px;text-align:center}
.stat-accent{border-bottom:2px solid var(--gold)}
.stat-n{font-size:24px;font-weight:500;color:var(--ink);margin:0;font-family:'Playfair Display',Georgia,serif}
.stat-n-gold{color:var(--gold-dark)}
.stat-l{font-size:10px;color:var(--ink-light);margin-top:4px;text-transform:uppercase;letter-spacing:.06em}
.alert-stripe{background:#fffbeb;border:1px solid #fbbf24;color:#92400e;padding:14px 18px;border-radius:10px;margin-bottom:20px;font-size:13px;display:flex;align-items:center;gap:10px}
.alert-stripe a{background:#b8953a;color:#fff;padding:6px 14px;border-radius:6px;font-size:12px;font-weight:700;text-decoration:none;display:inline-block;margin-top:8px}
.alert-success{background:#f0fdf4;border:1px solid #86efac;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:13px}
.alert-error{background:#fef2f2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:13px}
.card{background:#fff;border:1px solid var(--cream-dark);border-radius:12px;overflow:hidden;margin-bottom:20px}
.card-header{padding:16px 22px;border-bottom:1px solid var(--cream-dark);display:flex;align-items:center;justify-content:space-between;background:var(--cream)}
.card-title{font-size:12px;font-weight:600;color:var(--ink);text-transform:uppercase;letter-spacing:.07em}
.table{width:100%;border-collapse:collapse}
.table th{padding:10px 18px;text-align:left;font-size:10px;font-weight:600;color:var(--ink-light);text-transform:uppercase;border-bottom:1px solid var(--cream-dark);letter-spacing:.06em;white-space:nowrap}
.table td{padding:12px 18px;border-bottom:1px solid #f5f0e8;vertical-align:middle;font-size:13px;color:var(--ink)}
.table tr:last-child td{border-bottom:none}
.table tr:hover td{background:#fdfaf5}
.lot-img{width:42px;height:42px;border-radius:6px;object-fit:cover;background:var(--cream-dark);flex-shrink:0}
.btn{display:inline-flex;align-items:center;padding:5px 12px;border-radius:6px;font-size:11px;font-weight:600;text-decoration:none;border:none;cursor:pointer;white-space:nowrap;letter-spacing:.03em}
.btn-edit{background:var(--gold-light);color:var(--gold-dark);border:1px solid #e0c87a}
.btn-ship{background:var(--ink);color:var(--gold)}
.btn-view{background:var(--cream);color:var(--ink);border:1px solid var(--cream-dark)}
.shipping-row td{background:#f8f4ed;border-bottom:2px solid #e0d8c8;padding:14px 18px}
</style>

<div class="vd-body">
<div class="vd-wrap">

  @php $user = auth()->user(); @endphp

  @if(isset($disputas) && $disputas->count() > 0)
  <div style="background:#fff;border:1px solid #fca5a5;border-left:4px solid #dc2626;border-radius:12px;padding:20px 24px;margin-bottom:20px">
    <h2 style="font-size:16px;font-weight:700;color:#991b1b;margin:0 0 4px">Tenés una disputa que necesita tu respuesta</h2>
    <p style="font-size:13px;color:#6b7280;margin:0 0 16px">Un comprador abrió un reclamo. Contá tu versión antes de que el equipo resuelva.</p>
    @foreach($disputas as $d)
    <div style="border:1px solid #e5e7eb;border-radius:8px;padding:16px;margin-bottom:12px">
      <div style="font-size:14px;font-weight:700;color:#111827;margin-bottom:6px">{{ $d->auction->title ?? ('Lote #'.$d->auction_id) }}</div>
      <p style="font-size:13px;color:#374151;margin:0 0 4px"><strong>Motivo:</strong> {{ $d->reason }}</p>
      @if($d->description)<p style="font-size:13px;color:#6b7280;margin:0 0 12px;padding:10px;background:#f9fafb;border-radius:6px">"{{ $d->description }}"</p>@endif
      @if($d->seller_responded_at)
        <div style="font-size:12px;color:#16a34a;font-weight:600;margin-top:8px">Ya enviaste tu respuesta. El equipo la está revisando.</div>
      @else
        <form method="POST" action="{{ route('vendor.disputes.responder', $d->id) }}" style="margin-top:10px">
          @csrf
          <textarea name="seller_response" required maxlength="2000" placeholder="Contá qué pasó desde tu lado (envío, estado del objeto, comunicación con el comprador)..." style="width:100%;min-height:90px;border:1px solid #d1d5db;border-radius:8px;padding:10px;font-size:13px;font-family:inherit;box-sizing:border-box;resize:vertical"></textarea>
          <button type="submit" style="margin-top:8px;background:#1a3a6b;color:#fff;border:none;border-radius:8px;padding:10px 20px;font-size:13px;font-weight:600;cursor:pointer">Enviar mi respuesta</button>
        </form>
      @endif
    </div>
    @endforeach
  </div>
  @endif

  {{-- Header perfil --}}
  <div class="vd-header-card">
    <div class="vd-avatar">
      @if($user->avatar)
        <img src="{{ $user->avatar }}" alt="{{ $user->name }}">
      @else
        {{ strtoupper(substr($user->name,0,1)) }}
      @endif
    </div>
    <div style="flex:1;min-width:200px">
      <div style="display:flex;align-items:center;flex-wrap:wrap;gap:4px">
        <h1 class="vd-name">{{ $user->business_name ?: $user->name }}</h1>
        @if($user->is_featured_seller)
          <span class="badge-verified">✦ Verificado</span>
        @endif
      </div>
      @if($user->business_name)
        <p style="font-size:12px;color:var(--ink-light);margin:2px 0 0">{{ $user->name }}</p>
      @endif
      <p class="vd-since">Miembro desde {{ $user->created_at->format('F Y') }}
        @if($user->website) &nbsp;·&nbsp; <a href="{{ $user->website }}" target="_blank" style="color:var(--gold-dark)">{{ parse_url($user->website, PHP_URL_HOST) }}</a>@endif
      </p>
      @if($user->bio)
        <p class="vd-bio">{{ $user->bio }}</p>
      @endif
    </div>
    <a href="{{ route('vendor.create') }}" class="btn-new">+ Nuevo lote</a>
  </div>

  {{-- Stats --}}
  @php
    $vendidosStats = $auctions->whereIn('status',['paid','shipped','delivered','completed']);
    $ganancias  = $vendidosStats->sum('final_price');
    $comisiones = $vendidosStats->sum(function($a){ return $a->free_commission ? 0 : ($a->final_price * 0.09 + 3); });
    $neto       = $ganancias - $comisiones;
    $totalVistas= $auctions->sum('views_count');
    $totalPujas = $auctions->sum('total_bids');
  @endphp
  <div class="stats">
    <div class="stat stat-accent">
      <p class="stat-n">{{ $stats['activo'] }}</p>
      <p class="stat-l">Lotes activos</p>
    </div>
    <div class="stat">
      <p class="stat-n">{{ $stats['pendiente'] }}</p>
      <p class="stat-l">En revisión</p>
    </div>
    <div class="stat">
      <p class="stat-n">{{ number_format($totalVistas) }}</p>
      <p class="stat-l">Vistas totales</p>
    </div>
    <div class="stat">
      <p class="stat-n stat-n-gold">€{{ number_format($neto,0,',','.') }}</p>
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
  @if(!$user->stripe_onboarding_complete)
  <div class="alert-stripe">
    <span style="font-size:20px">⚠️</span>
    <div>
      <strong>Tu cuenta de pagos no está configurada.</strong><br>
      <span style="font-size:12px">Conectá tu cuenta Stripe para recibir el pago de tus ventas.</span>
      <a href="{{ route('vendor.stripe.onboarding') }}">Configurar cuenta →</a>
    </div>
  </div>
  @endif

  {{-- Rechazados --}}
  @php $rechazados = $auctions->where('status','cancelled'); @endphp
  @if($rechazados->count() > 0)
  <div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:10px;padding:16px 22px;margin-bottom:20px;">
    <p style="font-size:12px;font-weight:700;color:#991b1b;margin:0 0 8px;text-transform:uppercase;letter-spacing:.05em">Lotes rechazados ({{ $rechazados->count() }})</p>
    @foreach($rechazados as $lot)
    <div style="font-size:12px;color:#7f1d1d;padding:6px 0;border-top:1px solid #fecaca;display:flex;align-items:center;justify-content:space-between;gap:12px">
      <span><strong>{{ $lot->title }}</strong> — {{ $lot->rejection_reason ?? 'Sin motivo especificado' }}</span>
      <form method="POST" action="{{ route('vendor.lot.delete', $lot->id) }}" onsubmit="return confirm('Eliminar este lote?')">
        @csrf @method('DELETE')
        <button type="submit" style="background:#991b1b;color:#fff;border:none;border-radius:6px;padding:4px 12px;font-size:11px;font-weight:700;cursor:pointer">Eliminar</button>
      </form>
    </div>
    @endforeach
  </div>
  @endif

  {{-- Tabla lotes --}}
  @if($auctions->where('status','!=','cancelled')->isEmpty())
    <div class="card">
      <div style="text-align:center;padding:60px 0;color:var(--ink-light);">
        <p style="font-family:'Playfair Display',Georgia,serif;font-size:18px;margin-bottom:8px;color:var(--ink)">Todavía no tenés lotes</p>
        <p style="font-size:13px;margin-bottom:16px">Publicá tu primer objeto y llegá a compradores en toda Europa</p>
        <a href="{{ route('vendor.create') }}" style="background:var(--ink);color:var(--gold);padding:10px 22px;border-radius:8px;text-decoration:none;font-size:12px;font-weight:600;letter-spacing:.04em">Crear primer lote →</a>
      </div>
    </div>
  @else
  <div class="card">
    <div class="card-header">
      <span class="card-title">Mis lotes</span>
      <span style="font-size:11px;color:var(--ink-light)">{{ $auctions->where('status','!=','cancelled')->count() }} lotes</span>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>Lote</th>
          <th>Estado</th>
          <th style="text-align:right">Precio actual</th>
          <th style="text-align:center">Pujas</th>
          <th style="text-align:center">Vistas</th>
          <th style="text-align:right">Cierra</th>
          <th style="text-align:center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($auctions->where('status','!=','cancelled') as $lot)
        @php
          $img = !empty($lot->image_path) ? (str_starts_with($lot->image_path,'http') ? $lot->image_path : asset('storage/'.$lot->image_path)) : null;
          $cp  = $lot->current_price ?? $lot->base_price ?? 0;
          $conv = ($lot->views_count > 0) ? round(($lot->total_bids / $lot->views_count) * 100, 1) : 0;
          $statusMap = [
            'active'    => ['bg'=>'#edf7f0','color'=>'#2d6a4a','border'=>'#c0dece','label'=>'Activo'],
            'pending'   => ['bg'=>'#fef9ec','color'=>'#8a6820','border'=>'#e0c87a','label'=>'En revisión'],
            'finished'  => ['bg'=>'#f5f0e8','color'=>'#5a4f3a','border'=>'#d8d0c0','label'=>'Finalizado'],
            'paid'      => ['bg'=>'#eff6ff','color'=>'#1e40af','border'=>'#bfdbfe','label'=>'Pagado ✓'],
            'shipped'   => ['bg'=>'#eff6ff','color'=>'#1e40af','border'=>'#bfdbfe','label'=>'En tránsito 🚚'],
            'delivered' => ['bg'=>'#edf7f0','color'=>'#2d6a4a','border'=>'#c0dece','label'=>'Entregado ✓'],
            'completed' => ['bg'=>'#edf7f0','color'=>'#15803d','border'=>'#c0dece','label'=>'Completado ✓'],
          ];
          $sc = $statusMap[$lot->status] ?? ['bg'=>'#f5f0e8','color'=>'#5a4f3a','border'=>'#d8d0c0','label'=>ucfirst($lot->status)];
          $winner = ($lot->status === 'paid') ? \App\Models\User::find($lot->winner_id) : null;
        @endphp
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:12px">
              @if($img)
                <img src="{{ $img }}" class="lot-img">
              @else
                <div class="lot-img" style="display:flex;align-items:center;justify-content:center;color:#c0b090;font-size:18px">◻</div>
              @endif
              <a href="{{ route('auctions.show',$lot->id) }}" style="text-decoration:none">
                <p style="font-size:13px;font-weight:500;color:var(--ink);margin:0">{{ Str::limit($lot->title,42) }}</p>
                <p style="font-size:10px;color:var(--ink-light);margin:2px 0 0;letter-spacing:.04em">Lote #{{ str_pad($lot->id,4,'0',STR_PAD_LEFT) }}</p>
              </a>
            </div>
          </td>
          <td>
            <span style="background:{{ $sc['bg'] }};color:{{ $sc['color'] }};border:1px solid {{ $sc['border'] }};font-size:10px;font-weight:600;padding:3px 9px;border-radius:20px;letter-spacing:.04em">
              {{ $sc['label'] }}
            </span>
            @if($lot->status === 'pending')
              <p style="font-size:10px;color:var(--ink-light);margin:4px 0 0">Revisión 24-48h</p>
            @endif
          </td>
          <td style="text-align:right;font-size:14px;font-weight:500;color:{{ $lot->total_bids>0?'#2d6a4a':'var(--ink)' }};font-family:'Playfair Display',Georgia,serif">
            €{{ number_format($cp,0,',','.') }}
          </td>
          <td style="text-align:center;font-size:13px;color:var(--ink-light)">{{ $lot->total_bids ?? 0 }}</td>
          <td style="text-align:center">
            <span style="font-size:13px;color:var(--ink-light)">{{ number_format($lot->views_count ?? 0) }}</span>
            @if(($lot->views_count ?? 0) > 0)
              <span style="display:block;font-size:10px;color:#c0b090">{{ $conv }}%</span>
            @endif
          </td>
          <td style="text-align:right;font-size:11px;color:var(--ink-light)">
            @if($lot->end_time)
              {{ \Carbon\Carbon::parse($lot->end_time)->format('d/m/Y') }}<br>
              <span style="font-size:10px">{{ \Carbon\Carbon::parse($lot->end_time)->format('H:i') }}</span>
            @else — @endif
          </td>
          <td style="text-align:center">
            <div style="display:flex;gap:6px;justify-content:center;flex-wrap:wrap">
              @if(in_array($lot->status,['active','finished','paid','shipped','delivered','completed']))
                <a href="{{ route('auctions.show',$lot->id) }}" class="btn btn-view" target="_blank">Ver</a>
              @endif
              @if($lot->status === 'pending')
                <a href="{{ route('vendor.edit',$lot->id) }}" class="btn btn-edit">✏ Editar</a>
              @endif
              @if($lot->status === 'shipped')
                <span style="font-size:11px;color:#1e40af;font-weight:600">🚚 {{ $lot->tracking_number }}</span>
              @endif
            </div>
          </td>
        </tr>
        {{-- Fila expandida para lotes PAID: dirección + tracking --}}
        @if($lot->status === 'paid')
        <tr class="shipping-row">
          <td colspan="7">
            <div style="display:flex;gap:24px;align-items:flex-start;flex-wrap:wrap">
              {{-- Dirección de envío --}}
              <div style="flex:1;min-width:220px">
                <p style="font-size:11px;font-weight:700;color:#1a3a6b;margin:0 0 8px;text-transform:uppercase;letter-spacing:.06em">📦 Dirección de envío</p>
                @if($winner)
                  <p style="font-size:13px;font-weight:600;color:#111827;margin:0">{{ $winner->name }}</p>
                  <p style="font-size:12px;color:#374151;margin:2px 0">{{ $winner->address }}{{ $winner->city ? ', '.$winner->city : '' }}</p>
                  <p style="font-size:12px;color:#374151;margin:2px 0">{{ $winner->postal_code }} {{ $winner->country }}</p>
                  @if($winner->phone)<p style="font-size:12px;color:#374151;margin:2px 0">Tel: {{ $winner->phone }}</p>@endif
                @else
                  <p style="font-size:12px;color:#9ca3af;margin:0">Sin dirección registrada</p>
                @endif
              </div>
              {{-- Instrucciones --}}
              <div style="flex:1;min-width:220px">
                <p style="font-size:11px;font-weight:700;color:#1a3a6b;margin:0 0 8px;text-transform:uppercase;letter-spacing:.06em">📋 Instrucciones</p>
                <p style="font-size:12px;color:#374151;margin:0 0 4px">✓ Tenés <strong>3 días hábiles</strong> para enviar</p>
                <p style="font-size:12px;color:#374151;margin:0 0 4px">✓ Usá un servicio con número de tracking válido</p>
                <p style="font-size:12px;color:#374151;margin:0">✓ Guardá el comprobante de envío por si hay disputas</p>
                <p style="font-size:11px;color:#b45309;margin:6px 0 0;font-style:italic">Contacto RialBids: <a href="mailto:info@rialbids.com" style="color:#1a3a6b">info@rialbids.com</a></p>
              </div>
              {{-- Formulario tracking --}}
              <div style="flex:1;min-width:220px">
                <p style="font-size:11px;font-weight:700;color:#1a3a6b;margin:0 0 8px;text-transform:uppercase;letter-spacing:.06em">🔢 Cargar número de tracking</p>
                <form method="POST" action="{{ route('vendor.auctions.ship',$lot->id) }}" style="display:flex;flex-direction:column;gap:8px">
                  @csrf
                  <select name="tracking_carrier" required id="carrier_{{ $lot->id }}" onchange="updateTracking({{ $lot->id }})" style="border:1px solid var(--cream-dark);border-radius:6px;padding:8px 12px;font-size:12px;background:#fff;width:100%;box-sizing:border-box">
                    <option value="">-- Seleccionar courier --</option>
                    <option value="correos">Correos ES</option>
                    <option value="correos_pt">CTT Portugal</option>
                    <option value="dhl">DHL</option>
                    <option value="gls">GLS</option>
                    <option value="mrw">MRW</option>
                    <option value="seur">SEUR</option>
                    <option value="ups">UPS</option>
                    <option value="fedex">FedEx</option>
                    <option value="nacex">Nacex</option>
                    <option value="autre">Otro</option>
                  </select>
                  <input type="text" name="tracking_number" id="tracking_{{ $lot->id }}" placeholder="Seleccioná un courier primero" required
                    style="border:1px solid var(--cream-dark);border-radius:6px;padding:8px 12px;font-size:12px;background:#fff;width:100%;box-sizing:border-box">
                  <div id="tracking_hint_{{ $lot->id }}" style="font-size:11px;color:#6b7280;margin-top:-4px;display:none"></div>
                  @error("tracking_number")
                  <div style="color:#dc2626;font-size:11px;font-weight:600">{{ $message }}</div>
                  @enderror
                  <div style="background:#fef3c7;border:1px solid #f59e0b;border-radius:6px;padding:8px 10px;margin-bottom:6px;font-size:11px;color:#92400e">
                    ⚠️ <strong>Atención:</strong> Al confirmar declarás que el número de tracking es real y válido. Proporcionar información falsa puede resultar en la suspensión permanente de tu cuenta.
                  </div>
                  <button type="submit" style="background:#1a3a6b;color:#c9a84c;border:none;border-radius:6px;padding:8px 16px;font-size:12px;font-weight:700;cursor:pointer;letter-spacing:.04em">Marcar como enviado →</button>
                </form>
              </div>
            </div>
          </td>
        </tr>
        @endif
        @endforeach
      </tbody>
    </table>
  </div>
  @endif

  {{-- Historial ventas --}}
  @php $vendidos = $auctions->whereIn('status',['paid','shipped','delivered','completed']); @endphp
  @if($vendidos->count() > 0)
  <div class="card">
    <div class="card-header">
      <span class="card-title">Historial de ventas</span>
      <span style="font-size:11px;color:var(--ink-light)">{{ $vendidos->count() }} ventas · €{{ number_format($neto,2,',','.') }} neto</span>
    </div>
    <table class="table">
      <thead><tr>
        <th>Lote</th>
        <th style="text-align:right">Precio venta</th>
        <th style="text-align:right">Comisión RialBids</th>
        <th style="text-align:right">Tu ganancia</th>
        <th>Estado</th>
      </tr></thead>
      <tbody>
      @foreach($vendidos as $lot)
      @php
        $precio   = $lot->final_price ?? $lot->current_price ?? 0;
        $comision = $lot->free_commission ? 0 : (($precio * 0.09) + 3);
        $ganancia = $precio - $comision;
      @endphp
      <tr>
        <td style="font-weight:500">{{ Str::limit($lot->title,38) }}</td>
        <td style="text-align:right;font-weight:500;font-family:'Playfair Display',Georgia,serif">€{{ number_format($precio,2,',','.') }}</td>
        <td style="text-align:right;color:{{ $comision > 0 ? '#b45309' : '#16a34a' }}">
          @if($comision > 0)-€{{ number_format($comision,2,',','.') }}@else<span style="font-size:10px;font-weight:600;background:#dcfce7;color:#16a34a;padding:2px 8px;border-radius:20px">Primer lote gratis</span>@endif
        </td>
        <td style="text-align:right;font-weight:600;color:{{ $ganancia >= 0 ? '#2d6a4a' : '#dc2626' }};font-family:'Playfair Display',Georgia,serif">€{{ number_format($ganancia,2,',','.') }}</td>
        <td><span style="font-size:10px;background:#edf7f0;color:#2d6a4a;border:1px solid #c0dece;padding:2px 8px;border-radius:20px;font-weight:600">{{ ucfirst($lot->status) }}</span></td>
      </tr>
      @endforeach
      <tr style="background:var(--cream)">
        <td colspan="2" style="font-weight:600;color:var(--ink);font-size:12px;text-transform:uppercase;letter-spacing:.05em">Total</td>
        <td style="text-align:right;font-weight:600;color:#b45309">{{ $comisiones > 0 ? '-€'.number_format($comisiones,2,',','.') : '€0,00' }}</td>
        <td style="text-align:right;font-weight:600;color:{{ $neto >= 0 ? '#2d6a4a' : '#dc2626' }};font-size:15px;font-family:'Playfair Display',Georgia,serif">€{{ number_format($neto,2,',','.') }}</td>
        <td></td>
      </tr>
      </tbody>
    </table>
  </div>
  @endif

</div>
</div>
@endsection


<script>
function updateTracking(lotId) {
    var carrier = document.getElementById("carrier_" + lotId).value;
    var input = document.getElementById("tracking_" + lotId);
    var hint = document.getElementById("tracking_hint_" + lotId);
    var formats = {
        "correos": {ph: "ES000000000ES", hint: "13 caracteres: ES + 9 digitos + ES"},
        "correos_pt": {ph: "CT000000000PT", hint: "13 caracteres: CT + 9 digitos + PT"},
        "dhl": {ph: "1234567890", hint: "10 digitos numericos"},
        "gls": {ph: "12345678", hint: "8 a 14 caracteres"},
        "mrw": {ph: "1234567890123", hint: "13 caracteres"},
        "seur": {ph: "1234567890123", hint: "13 digitos"},
        "ups": {ph: "1Z999AA10123456784", hint: "Empieza con 1Z + 16 caracteres"},
        "fedex": {ph: "123456789012", hint: "12 a 22 digitos"},
        "nacex": {ph: "1234567890", hint: "10 digitos"},
        "autre": {ph: "XXXXXXXX", hint: "Minimo 8 caracteres alfanumericos"}
    };
    if (formats[carrier]) {
        input.placeholder = formats[carrier].ph;
        hint.textContent = "Formato esperado: " + formats[carrier].hint;
        hint.style.display = "block";
    } else {
        input.placeholder = "Selecciona un courier primero";
        hint.style.display = "none";
    }
}
</script>