@extends('layouts.app')
@section('content')
<style>
*{box-sizing:border-box}
.admin-wrap{display:flex;min-height:100vh;background:#f3f4f6;font-family:'Inter',sans-serif}
.sidebar{width:220px;background:#fff;border-right:1px solid #e5e7eb;padding:24px 0;flex-shrink:0;position:sticky;top:60px;height:calc(100vh - 60px);overflow-y:auto}
.sb-logo{padding:0 20px 20px;border-bottom:1px solid #e5e7eb;margin-bottom:16px}
.sb-logo span{font-weight:700;font-size:16px;color:#1a56db}
.sb-section{padding:0 12px;margin-bottom:8px}
.sb-label{font-size:10px;font-weight:600;color:#9ca3af;letter-spacing:.08em;text-transform:uppercase;padding:0 8px;margin-bottom:6px}
.sb-link{display:flex;align-items:center;gap:8px;padding:8px;border-radius:6px;text-decoration:none;font-size:13px;font-weight:500;color:#374151;transition:background .15s}
.sb-link:hover,.sb-link.active{background:#eff6ff;color:#1a56db}
.main{flex:1;padding:28px;overflow-x:auto}
.page-title{font-size:22px;font-weight:700;color:#111827;margin-bottom:24px}
.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:28px}
.stat-card{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:20px}
.stat-label{font-size:11px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px}
.stat-val{font-size:28px;font-weight:700;color:#111827}
.stat-sub{font-size:12px;color:#9ca3af;margin-top:4px}
.card{background:#fff;border:1px solid #e5e7eb;border-radius:10px;margin-bottom:24px}
.card-header{padding:16px 20px;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;justify-content:space-between}
.card-title{font-size:15px;font-weight:600;color:#111827}
.badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600}
.badge-active{background:#d1fae5;color:#065f46}
.badge-pending{background:#fef3c7;color:#92400e}
.badge-finished{background:#e5e7eb;color:#374151}
.badge-shipped{background:#dbeafe;color:#1e40af}
.badge-paid{background:#ede9fe;color:#5b21b6}
.badge-cancelled{background:#fee2e2;color:#991b1b}
.table{width:100%;border-collapse:collapse}
.table th{padding:10px 12px;text-align:left;font-size:11px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e5e7eb}
.table td{padding:12px;border-bottom:1px solid #f3f4f6;vertical-align:middle;font-size:13px;color:#374151}
.table tr:last-child td{border-bottom:none}
.table tr:hover td{background:#f9fafb}
.btn{display:inline-flex;align-items:center;padding:6px 12px;border-radius:6px;font-size:12px;font-weight:600;text-decoration:none;border:none;cursor:pointer;transition:opacity .15s}
.btn:hover{opacity:.85}
.btn-primary{background:#1a56db;color:#fff}
.btn-success{background:#059669;color:#fff}
.btn-danger{background:#dc2626;color:#fff}
.btn-ghost{background:#f3f4f6;color:#374151}
.lot-img{width:44px;height:44px;border-radius:6px;object-fit:cover;background:#f3f4f6}
.pending-alert{background:#fef3c7;border:1px solid #fbbf24;border-radius:10px;padding:16px 20px;margin-bottom:24px;display:flex;align-items:center;gap:12px}
.pending-count{background:#f59e0b;color:#fff;border-radius:50%;width:28px;height:28px;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;flex-shrink:0}
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
      <a href="{{ route('admin.index') }}" class="sb-link">📦 Lotes</a>
      <a href="{{ route('admin.index') }}" class="sb-link">🔨 Pujas</a>
      <a href="{{ route('admin.index') }}" class="sb-link">👥 Clientes</a>
      <a href="{{ route('admin.finanzas') }}" class="sb-link">💰 Finanzas</a>
    </div>
    <div class="sb-section">
      <div class="sb-label">Configuración</div>
      <a href="{{ route('admin.banners.index') }}" class="sb-link">🖼️ Banners</a>
    </div>
    <div class="sb-section">
      <div class="sb-label">Legal</div>
      <a href="{{ route('pages.terminos') }}" class="sb-link">📄 Términos</a>
      <a href="{{ route('pages.privacidad') }}" class="sb-link">🔒 Privacidad</a>
      <a href="{{ route('pages.proteccion-comprador') }}" class="sb-link">🛡️ Protección</a>
    </div>
  </div>

  <div class="main">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px">
      <h1 class="page-title" style="margin:0">Panel de Control</h1>
      <a href="{{ route('admin.auctions.create') }}" class="btn btn-primary">➕ Nuevo Lote</a>
    </div>

    <div class="stats">
      <div class="stat-card">
        <div class="stat-label">Total Lotes</div>
        <div class="stat-val">{{ $auctions->count() }}</div>
        <div class="stat-sub">En la plataforma</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Activos</div>
        <div class="stat-val" style="color:#059669">{{ $auctions->where('status','active')->count() }}</div>
        <div class="stat-sub">En curso ahora</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Total Pujas</div>
        <div class="stat-val">{{ $recentBids->count() }}</div>
        <div class="stat-sub">Todas las ofertas</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Clientes</div>
        <div class="stat-val">{{ $users->count() }}</div>
        <div class="stat-sub">Usuarios registrados</div>
      </div>
    </div>

    @php $pendientes = $auctions->where('status','pending'); @endphp
    @if($pendientes->count() > 0)
    <div class="pending-alert">
      <div class="pending-count">{{ $pendientes->count() }}</div>
      <div>
        <strong style="color:#92400e">Lotes pendientes de aprobación</strong>
        <div style="font-size:13px;color:#78350f">Revisá y aprobá o rechazá los lotes enviados por vendors.</div>
      </div>
    </div>
    @endif

    @if($pendientes->count() > 0)
    <div class="card">
      <div class="card-header">
        <span class="card-title">⏳ Pendientes de Aprobación</span>
      </div>
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
              @if($pimg)<img src="{{ $pimg }}" class="lot-img">@else<div class="lot-img" style="display:flex;align-items:center;justify-content:center;color:#d1d5db">📷</div>@endif
              <div>
                <div style="font-weight:600;color:#111827">{{ $auc->title }}</div>
                <div style="font-size:11px;color:#9ca3af">#{{ str_pad($auc->id,4,'0',STR_PAD_LEFT) }}</div>
              </div>
            </div>
          </td>
          <td>{{ $auc->user->name ?? '—' }}</td>
          <td style="font-weight:600">€{{ number_format($auc->base_price,0,',','.') }}</td>
          <td>{{ $auc->lot_category ?? '—' }}</td>
          <td>
            <div style="display:flex;gap:6px;flex-wrap:wrap">
              <a href="{{ route('auctions.show',$auc->id) }}" class="btn btn-ghost">Ver</a>
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

    <div class="card">
      <div class="card-header">
        <span class="card-title">📦 Todos los Lotes</span>
        <span style="font-size:13px;color:#6b7280">{{ $auctions->count() }} total</span>
      </div>
      <table class="table">
        <thead><tr>
          <th>Lote</th><th>Precio</th><th>Pujas</th><th>Estado</th><th>Cierre</th><th>Comprador</th><th>Tracking</th><th>Acciones</th>
        </tr></thead>
        <tbody>
        @foreach($auctions as $auc)
        @php
          $img = !empty($auc->image_path) ? (str_starts_with($auc->image_path,'http') ? $auc->image_path : asset('storage/'.$auc->image_path)) : null;
          $estados = ['active'=>'Activo','pending'=>'Pendiente','finished'=>'Finalizado','shipped'=>'Enviado','paid'=>'Pagado','cancelled'=>'Cancelado'];
          $badgeClass = ['active'=>'badge-active','pending'=>'badge-pending','finished'=>'badge-finished','shipped'=>'badge-shipped','paid'=>'badge-paid','cancelled'=>'badge-cancelled'];
        @endphp
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:10px">
              @if($img)<img src="{{ $img }}" class="lot-img">@else<div class="lot-img" style="display:flex;align-items:center;justify-content:center;color:#d1d5db">📷</div>@endif
              <div>
                <div style="font-weight:600;color:#111827;max-width:180px">{{ Str::limit($auc->title,35) }}</div>
                <div style="font-size:11px;color:#9ca3af">#{{ str_pad($auc->id,4,'0',STR_PAD_LEFT) }}</div>
              </div>
            </div>
          </td>
          <td style="font-weight:600;color:#1a56db">€{{ number_format($auc->current_price??$auc->base_price,0,',','.') }}</td>
          <td>{{ $auc->total_bids ?? 0 }}</td>
          <td><span class="badge {{ $badgeClass[$auc->status] ?? 'badge-pending' }}">{{ $estados[$auc->status] ?? $auc->status }}</span></td>
          <td style="font-size:12px">{{ $auc->end_time ? \Carbon\Carbon::parse($auc->end_time)->format('d/m/Y H:i') : '—' }}</td>
          <td style="font-size:12px">{{ $auc->winner->name ?? '—' }}</td>
          <td style="font-size:12px;color:#6b7280">{{ $auc->tracking_number ?? '—' }}</td>
          <td>
            <div style="display:flex;gap:4px">
              <a href="{{ route('auctions.show',$auc->id) }}" class="btn btn-ghost">Ver</a>
              <a href="{{ route('admin.auctions.edit',$auc->id) }}" class="btn btn-primary">Editar</a>
            </div>
          </td>
        </tr>
        @endforeach
        </tbody>
      </table>
    </div>

    <div class="card">
      <div class="card-header"><span class="card-title">👥 Clientes</span></div>
      <table class="table">
        <thead><tr><th>Nombre</th><th>Email</th><th>Rol</th><th>Pujas</th><th>Registro</th></tr></thead>
        <tbody>
        @foreach($users as $u)
        <tr>
          <td style="font-weight:600">{{ $u->name }}</td>
          <td style="color:#6b7280">{{ $u->email }}</td>
          <td><span class="badge {{ $u->role==='admin'?'badge-paid':($u->role==='seller'?'badge-active':'badge-finished') }}">{{ ucfirst($u->role) }}</span></td>
          <td>{{ $u->bids_count ?? 0 }}</td>
          <td style="font-size:12px;color:#9ca3af">{{ $u->created_at->format('d/m/Y') }}</td>
        </tr>
        @endforeach
        </tbody>
      </table>
    </div>

  </div>
</div>
@endsection
