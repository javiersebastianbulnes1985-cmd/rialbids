@extends('layouts.app')
@section('content')
<style>
*{box-sizing:border-box}
.admin-wrap{display:flex;min-height:100vh;background:#f3f4f6}
.sidebar{width:220px;background:#fff;border-right:1px solid #e5e7eb;padding:24px 0;flex-shrink:0;position:sticky;top:60px;height:calc(100vh - 60px);overflow-y:auto}
    @media(max-width:768px){.admin-wrap{flex-direction:column!important}.sidebar{width:100%!important;height:auto!important;position:relative!important;top:0!important;display:flex!important;flex-wrap:wrap!important;overflow:visible!important;border-right:none!important;border-bottom:1px solid #e5e7eb!important;padding:8px!important}.sb-section{padding:0 6px!important}.sb-link{padding:5px 8px!important;font-size:11px!important}.main{padding:12px!important}.stats{grid-template-columns:repeat(2,1fr)!important}}
.sb-logo{padding:0 20px 20px;border-bottom:1px solid #e5e7eb;margin-bottom:16px}
.sb-logo span{font-weight:700;font-size:15px;color:#1a56db}
.sb-section{padding:0 12px;margin-bottom:8px}
.sb-label{font-size:10px;font-weight:600;color:#9ca3af;letter-spacing:.08em;text-transform:uppercase;padding:0 8px;margin-bottom:6px}
.sb-link{display:flex;align-items:center;gap:8px;padding:8px;border-radius:6px;text-decoration:none;font-size:13px;font-weight:500;color:#374151;transition:background .15s}
.sb-link:hover,.sb-link.active{background:#eff6ff;color:#1a56db}
.main{flex:1;padding:24px;overflow-x:auto;min-width:0}
.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px}
.stat-card{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:18px}
.stat-label{font-size:11px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.05em;margin-bottom:6px}
.stat-val{font-size:26px;font-weight:700;color:#111827}
.stat-sub{font-size:12px;color:#9ca3af;margin-top:3px}
.card{background:#fff;border:1px solid #e5e7eb;border-radius:10px;margin-bottom:20px;overflow:hidden}
.card-header{padding:14px 18px;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap}
.card-title{font-size:14px;font-weight:700;color:#111827}
.badge{display:inline-block;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:600}
.badge-active{background:#d1fae5;color:#065f46}
.badge-pending{background:#fef3c7;color:#92400e}
.badge-finished{background:#e5e7eb;color:#374151}
.badge-shipped{background:#dbeafe;color:#1e40af}
.badge-paid{background:#ede9fe;color:#5b21b6}
.badge-cancelled{background:#fee2e2;color:#991b1b}
.badge-completed{background:#d1fae5;color:#065f46}
.table{width:100%;border-collapse:collapse}
.table th{padding:9px 12px;text-align:left;font-size:11px;font-weight:600;color:#6b7280;text-transform:uppercase;border-bottom:1px solid #e5e7eb;white-space:nowrap}
.table td{padding:10px 12px;border-bottom:1px solid #f3f4f6;vertical-align:middle;font-size:13px;color:#374151}
.table tr:last-child td{border-bottom:none}
.table tr:hover td{background:#f9fafb}
.btn{display:inline-flex;align-items:center;padding:5px 10px;border-radius:6px;font-size:12px;font-weight:600;text-decoration:none;border:none;cursor:pointer;white-space:nowrap}
.btn-primary{background:#1a56db;color:#fff}
.btn-success{background:#059669;color:#fff}
.btn-danger{background:#dc2626;color:#fff}
.btn-ghost{background:#f3f4f6;color:#374151}
.lot-img{width:40px;height:40px;border-radius:6px;object-fit:cover;background:#f3f4f6;flex-shrink:0}
.pending-alert{background:#fef3c7;border:1px solid #fbbf24;border-radius:10px;padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:12px}
.pending-count{background:#f59e0b;color:#fff;border-radius:50%;width:26px;height:26px;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;flex-shrink:0}
.filter-bar{display:flex;gap:8px;flex-wrap:wrap}
.filter-btn{padding:5px 12px;border-radius:20px;font-size:12px;font-weight:600;border:1px solid #e5e7eb;background:#fff;color:#6b7280;cursor:pointer;text-decoration:none}
.filter-btn.active,.filter-btn:hover{background:#1a56db;color:#fff;border-color:#1a56db}
</style>

<div class="admin-wrap">
  <div class="sidebar">
    <div class="sb-logo"><span>⚙️ RialBids Admin</span></div>
    <div class="sb-section">
      <div class="sb-label">General</div>
      <a href="{{ route('admin.index') }}" class="sb-link active">📊 Dashboard</a>
      <a href="{{ route('admin.auctions.create') }}" class="sb-link">➕ Nuevo Lote</a>
    </div>
    <div class="sb-section">
      <div class="sb-label">Gestión</div>
      <a href="{{ route('admin.index') }}#lotes" class="sb-link">📦 Lotes</a>
      <a href="{{ route('admin.index') }}#vendors" class="sb-link">🛒 Vendors</a>
      <a href="{{ route('admin.index') }}#compradores" class="sb-link">👤 Compradores</a>
      <a href="{{ route('admin.finanzas') }}" class="sb-link">💰 Finanzas</a>
      <a href="{{ route('admin.pagos') }}" class="sb-link">🔴 Pagos y Disputas</a>
    </div>
    <div class="sb-section">
      <div class="sb-label">Configuración</div>
      <a href="{{ route('admin.banners.index') }}" class="sb-link">🖼️ Banners</a>
    </div>
    <div class="sb-section">
      <div class="sb-label">Legal</div>
      <a href="/terminos" target="_blank" class="sb-link">📄 Términos</a>
      <a href="/privacidad" target="_blank" class="sb-link">🔒 Privacidad</a>
      <a href="/garantia" target="_blank" class="sb-link">🛡️ Garantía</a>
    </div>
  </div>

  <div class="main">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
      <h1 style="font-size:20px;font-weight:700;color:#111827;margin:0">Panel de Control</h1>
      <a href="{{ route('admin.auctions.create') }}" class="btn btn-primary">➕ Nuevo Lote</a>
    </div>

    {{-- Stats --}}
    <div class="stats">
      <div class="stat-card">
        <div class="stat-label">Total Lotes</div>
        <div class="stat-val">{{ $auctions->count() }}</div>
        <div class="stat-sub">En la plataforma</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Activos</div>
        <div class="stat-val" style="color:#059669">{{ $auctions->where('status','active')->count() }}</div>
        <div class="stat-sub">En curso ahora — <strong>{{ $auctions->where('status','active')->count() }} en vivo</strong></div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Total Pujas</div>
        <div class="stat-val">{{ $auctions->sum('total_bids') }}</div>
        <div class="stat-sub">Todas las ofertas</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Clientes</div>
        <div class="stat-val">{{ $users->count() }}</div>
        <div class="stat-sub">Usuarios registrados</div>
      </div>
    </div>

    {{-- Pendientes --}}
    @php $pendientes = $auctions->where('status','pending'); @endphp
    @if($pendientes->count() > 0)
    <div class="pending-alert">
      <div class="pending-count">{{ $pendientes->count() }}</div>
      <div>
        <div style="font-weight:700;color:#92400e;font-size:14px">Lotes pendientes de aprobación</div>
        <div style="font-size:12px;color:#78350f">Revisá y aprobá o rechazá los lotes enviados por vendors.</div>
      </div>
    </div>
    <div class="card" id="pendientes">
      <div class="card-header"><span class="card-title">⏳ Pendientes de Aprobación</span></div>
      <table class="table">
        <thead><tr>
          <th>Lote</th><th>Vendor</th><th>Precio base</th><th>Categoría</th><th>Acciones</th>
        </tr></thead>
        <tbody>
        @foreach($pendientes as $auc)
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:10px">
              @php $pimg = !empty($auc->image_path) ? (str_starts_with($auc->image_path,'http') ? $auc->image_path : asset('storage/'.$auc->image_path)) : null; @endphp
              @if($pimg)<img src="{{ $pimg }}" class="lot-img">@else<div class="lot-img" style="display:flex;align-items:center;justify-content:center;font-size:18px">📷</div>@endif
              <div>
                <div style="font-weight:600;color:#111827">{{ Str::limit($auc->title,40) }}</div>
                <div style="font-size:11px;color:#9ca3af">#{{ str_pad($auc->id,4,'0',STR_PAD_LEFT) }}</div>
              </div>
            </div>
          </td>
          <td>
            <div style="font-weight:600;font-size:12px">{{ $auc->user->name ?? '—' }}</div>
            <div style="font-size:11px;color:#9ca3af">{{ $auc->user->email ?? '' }}</div>
          </td>
          <td style="font-weight:700;color:#1a56db">€{{ number_format($auc->base_price,0,',','.') }}</td>
          <td>{{ $auc->lot_category ?? '—' }}</td>
          <td>
            <div style="display:flex;gap:6px;align-items:center;flex-wrap:wrap">
              <a href="{{ route('auctions.show',$auc->id) }}" class="btn btn-ghost" target="_blank">👁 Ver</a>
              <form method="POST" action="{{ route('admin.approve',$auc->id) }}" style="display:inline">@csrf<button class="btn btn-success">✅ Aprobar</button></form>
              <button onclick="document.getElementById('reject-{{ $auc->id }}').style.display='block'" class="btn btn-danger">❌ Rechazar</button>
            </div>
            <div id="reject-{{ $auc->id }}" style="display:none;margin-top:8px">
              <form method="POST" action="{{ route('admin.reject',$auc->id) }}">@csrf
                <input type="text" name="reason" placeholder="Motivo del rechazo..." style="width:100%;padding:6px 10px;border:1px solid #e5e7eb;border-radius:6px;font-size:12px;margin-bottom:6px">
                <button class="btn btn-danger">Confirmar rechazo</button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    @endif

    {{-- Todos los lotes --}}
    <div class="card" id="lotes">
      <div class="card-header">
        <span class="card-title">📦 Todos los Lotes</span>
        <div class="filter-bar">
          <a href="{{ route('admin.index') }}" class="filter-btn {{ !request('estado') ? 'active' : '' }}">Todos ({{ $auctions->count() }})</a>
          <a href="{{ route('admin.index') }}?estado=active" class="filter-btn {{ request('estado')==='active' ? 'active' : '' }}">Activos ({{ $auctions->where('status','active')->count() }})</a>
          <a href="{{ route('admin.index') }}?estado=pending" class="filter-btn {{ request('estado')==='pending' ? 'active' : '' }}">Pendientes ({{ $auctions->where('status','pending')->count() }})</a>
          <a href="{{ route('admin.index') }}?estado=finished" class="filter-btn {{ request('estado')==='finished' ? 'active' : '' }}">Finalizados ({{ $auctions->where('status','finished')->count() }})</a>
        </div>
      </div>
      <table class="table">
        <thead><tr>
          <th>Lote</th><th>Vendor</th><th>Precio</th><th>Pujas</th><th>Estado</th><th>Cierre</th><th>Acciones</th>
        </tr></thead>
        <tbody>
        @php
          $estados = ['active'=>'Activo','pending'=>'Pendiente','finished'=>'Finalizado','shipped'=>'Enviado','paid'=>'Pagado','cancelled'=>'Cancelado','completed'=>'Completado'];
          $badgeClass = ['active'=>'badge-active','pending'=>'badge-pending','finished'=>'badge-finished','shipped'=>'badge-shipped','paid'=>'badge-paid','cancelled'=>'badge-cancelled','completed'=>'badge-completed'];
          $filtrados = request('estado') ? $auctions->where('status', request('estado')) : $auctions;
        @endphp
        @foreach($filtrados as $auc)
        @php $img = !empty($auc->image_path) ? (str_starts_with($auc->image_path,'http') ? $auc->image_path : asset('storage/'.$auc->image_path)) : null; @endphp
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:10px">
              @if($img)<img src="{{ $img }}" class="lot-img">@else<div class="lot-img" style="display:flex;align-items:center;justify-content:center;font-size:18px">📷</div>@endif
              <div>
                <div style="font-weight:600;color:#111827;max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $auc->title }}</div>
                <div style="font-size:11px;color:#9ca3af">#{{ str_pad($auc->id,4,'0',STR_PAD_LEFT) }}</div>
              </div>
            </div>
          </td>
          <td>
            <div style="font-size:12px;font-weight:600">{{ $auc->user->name ?? '—' }}</div>
          </td>
          <td style="font-weight:700;color:#1a56db;white-space:nowrap">€{{ number_format($auc->current_price??$auc->base_price,0,',','.') }}</td>
          <td style="text-align:center">{{ $auc->total_bids ?? 0 }}</td>
          <td><span class="badge {{ $badgeClass[$auc->status] ?? 'badge-pending' }}">{{ $estados[$auc->status] ?? $auc->status }}</span></td>
          <td style="font-size:12px;white-space:nowrap">{{ $auc->end_time ? \Carbon\Carbon::parse($auc->end_time)->format('d/m/y H:i') : '—' }}</td>
          <td>
            <div style="display:flex;gap:4px">
              <a href="{{ route('auctions.show',$auc->id) }}" class="btn btn-ghost" target="_blank">Ver</a>
              <a href="{{ route('admin.auctions.edit',$auc->id) }}" class="btn btn-primary">Editar</a>
            </div>
          </td>
        </tr>
        @endforeach
        </tbody>
      </table>
    </div>

    {{-- Vendors --}}
    @php $vendors = $users->where('role','seller'); $compradores = $users->where('role','bidder'); @endphp
    <div class="card" id="vendors">
      <div class="card-header">
        <span class="card-title">🛒 Vendors</span>
        <span style="font-size:12px;color:#6b7280">{{ $vendors->count() }} registrados</span>
      </div>
      <table class="table">
        <thead><tr><th>Nombre</th><th>Email</th><th>Lotes</th><th>Activos</th><th>Stripe</th><th>Registro</th></tr></thead>
        <tbody>
        @foreach($vendors as $u)
        @php
          $lotesVendor = $auctions->where('user_id', $u->id);
          $stripeOk = $u->stripe_onboarding_complete ?? false;
        @endphp
        <tr>
          <td style="font-weight:600">{{ $u->name }}</td>
          <td style="color:#6b7280;font-size:12px">{{ $u->email }}</td>
          <td style="text-align:center">{{ $lotesVendor->count() }}</td>
          <td style="text-align:center">{{ $lotesVendor->where('status','active')->count() }}</td>
          <td style="text-align:center">
            @if($stripeOk)
              <span class="badge badge-active">✓ Configurado</span>
            @else
              <span class="badge badge-pending">Pendiente</span>
            @endif
          </td>
          <td style="font-size:12px;color:#9ca3af">{{ $u->created_at->format('d/m/Y') }}</td>
        </tr>
        @endforeach
        </tbody>
      </table>
    </div>

    {{-- Compradores --}}
    <div class="card" id="compradores">
      <div class="card-header">
        <span class="card-title">👤 Compradores</span>
        <span style="font-size:12px;color:#6b7280">{{ $compradores->count() }} registrados</span>
      </div>
      <table class="table">
        <thead><tr><th>Nombre</th><th>Email</th><th>Pujas</th><th>Lotes ganados</th><th>Registro</th></tr></thead>
        <tbody>
        @foreach($compradores as $u)
        @php $ganados = $auctions->where('winner_id', $u->id)->count(); @endphp
        <tr>
          <td style="font-weight:600">{{ $u->name }}</td>
          <td style="color:#6b7280;font-size:12px">{{ $u->email }}</td>
          <td style="text-align:center">{{ $u->bids_count ?? 0 }}</td>
          <td style="text-align:center">{{ $ganados }}</td>
          <td style="font-size:12px;color:#9ca3af">{{ $u->created_at->format('d/m/Y') }}</td>
        </tr>
        @endforeach
        </tbody>
      </table>
    </div>

  </div>
</div>
@endsection
