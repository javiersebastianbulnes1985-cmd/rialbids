<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin — RialBids</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Inter',sans-serif;background:#0a0a0b;color:#fff;display:flex;min-height:100vh}
.sidebar{width:210px;background:#111113;border-right:1px solid rgba(255,255,255,0.06);display:flex;flex-direction:column;position:fixed;top:0;left:0;height:100vh}
.sb-logo{padding:20px;border-bottom:1px solid rgba(255,255,255,0.06);display:flex;align-items:center;gap:10px;text-decoration:none}
.sb-box{width:32px;height:32px;background:#1a56db;border-radius:5px;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:14px;color:#fff;flex-shrink:0}
.sb-name{font-weight:700;font-size:15px;color:#fff}
.sb-sec{padding:16px 10px 6px;font-size:10px;font-weight:600;letter-spacing:.15em;text-transform:uppercase;color:rgba(255,255,255,0.2)}
.sb-item{display:flex;align-items:center;padding:9px 12px;border-radius:6px;text-decoration:none;font-size:13px;font-weight:500;color:rgba(255,255,255,0.4);margin:1px 8px;transition:all .15s}
.sb-item:hover{background:#161618;color:#fff}
.sb-item.on{background:#161618;color:#1a56db}
.sb-foot{margin-top:auto;padding:16px 20px;border-top:1px solid rgba(255,255,255,0.06)}
.sb-foot a{font-size:12px;color:rgba(255,255,255,0.25);text-decoration:none}
.sb-foot a:hover{color:#1a56db}
.main{margin-left:210px;flex:1}
.topbar{background:#111113;border-bottom:1px solid rgba(255,255,255,0.06);padding:0 28px;height:58px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:5}
.topbar h1{font-size:16px;font-weight:600}
.btn{background:#1a56db;color:#fff;padding:9px 18px;border-radius:6px;font-size:12px;font-weight:700;text-decoration:none;border:none;cursor:pointer;font-family:'Inter',sans-serif}
.btn:hover{background:#1e429f}
.content{padding:28px}
.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:28px}
.stat{background:#111113;border:1px solid rgba(255,255,255,0.06);border-radius:8px;padding:18px 20px}
.sl{font-size:10px;font-weight:600;letter-spacing:.15em;text-transform:uppercase;color:rgba(255,255,255,0.25);margin-bottom:8px}
.sv{font-size:28px;font-weight:700;line-height:1}
.ss{font-size:11px;color:rgba(255,255,255,0.3);margin-top:5px}
.box{background:#111113;border:1px solid rgba(255,255,255,0.06);border-radius:8px;overflow:hidden;margin-bottom:20px}
.bh{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid rgba(255,255,255,0.06)}
.bt{font-size:13px;font-weight:600}
.bc{font-size:11px;color:rgba(255,255,255,0.25);background:#161618;padding:3px 10px;border-radius:20px}
table{width:100%;border-collapse:collapse}
th{text-align:left;font-size:10px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,0.2);padding:11px 20px;border-bottom:1px solid rgba(255,255,255,0.06)}
td{padding:13px 20px;border-bottom:1px solid rgba(255,255,255,0.04);font-size:13px}
tr:last-child td{border-bottom:none}
tbody tr:hover{background:#161618}
.badge{display:inline-block;font-size:10px;font-weight:600;text-transform:uppercase;padding:3px 10px;border-radius:20px}
.badge-active{background:rgba(52,211,153,.12);color:#34d399}
.badge-pending{background:rgba(251,191,36,.12);color:#fbbf24}
.badge-finished,.badge-draft{background:#161618;color:rgba(255,255,255,0.25)}
.a{font-size:12px;text-decoration:none;padding:4px 10px;border-radius:4px;font-weight:500;background:none;border:none;cursor:pointer;font-family:'Inter',sans-serif}
.av{color:rgba(255,255,255,0.3)}.av:hover{color:#1a56db}
.aa{color:rgba(52,211,153,.6)}.aa:hover{color:#34d399}
.ad{color:rgba(248,113,113,.4)}.ad:hover{color:#f87171}
.thumb{width:42px;height:42px;border-radius:4px;object-fit:cover}
.nothumb{width:42px;height:42px;border-radius:4px;background:#161618;display:flex;align-items:center;justify-content:center;font-size:18px}
.flash{padding:12px 18px;border-radius:6px;font-size:13px;font-weight:500;margin-bottom:20px;background:rgba(52,211,153,.1);border:1px solid rgba(52,211,153,.2);color:#34d399}
.empty{text-align:center;padding:40px;color:rgba(255,255,255,0.2);font-size:13px}
</style>
</head>
<body>
<aside class="sidebar">
  <a href="{{ route('admin.index') }}" class="sb-logo">
    <div class="sb-box">R</div><span class="sb-name">RialBids</span>
  </a>
  <div class="sb-sec">General</div>
  <a href="{{ route('admin.index') }}" class="sb-item on">Dashboard</a>
  <a href="{{ route('admin.auctions.create') }}" class="sb-item">+ Nuevo Lote</a>
  <div class="sb-sec">Gestión</div>
  <a href="#lotes" class="sb-item">Lotes</a>
  <a href="#pujas" class="sb-item">Pujas</a>
  <a href="#clientes" class="sb-item">Clientes</a>
  <div class="sb-foot"><a href="{{ route('home') }}">← Sitio público</a></div>
</aside>
<div class="main">
  <div class="topbar">
    <h1>Panel de Control</h1>
    <a href="{{ route('admin.auctions.create') }}" class="btn">+ Nuevo Lote</a>
  </div>
  <div class="content">
    @if(session('success'))<div class="flash">✓ {{ session('success') }}</div>@endif
    <div class="stats">
      <div class="stat"><div class="sl">Total Lotes</div><div class="sv" style="color:#1a56db">{{ $auctions->count() }}</div><div class="ss">En la plataforma</div></div>
      <div class="stat"><div class="sl">Activos</div><div class="sv" style="color:#34d399">{{ $auctions->where('status','active')->count() }}</div><div class="ss">En curso ahora</div></div>
      <div class="stat"><div class="sl">Total Pujas</div><div class="sv" style="color:#60a5fa">{{ $totalBids??0 }}</div><div class="ss">Todas las ofertas</div></div>
      <div class="stat"><div class="sl">Clientes</div><div class="sv" style="color:#fff">{{ $totalUsers??0 }}</div><div class="ss">Usuarios registrados</div></div>
    </div>
    <div class="box" id="lotes">
      <div class="bh"><span class="bt">Lotes</span><span class="bc">{{ $auctions->count() }} total</span></div>
      <table>
        <thead><tr><th></th><th>Lote</th><th>Precio</th><th>Pujas</th><th>Estado</th><th>Cierre</th><th></th></tr></thead>
        <tbody>
        @forelse($auctions as $auc)
        <tr>
          <td>@if(!empty($auc->image_path))<img src="{{ asset('storage/'.$auc->image_path) }}" class="thumb">@else<div class="nothumb">📦</div>@endif</td>
          <td><div style="font-weight:500;color:#fff">{{ Str::limit($auc->title,40) }}</div><div style="font-size:11px;color:rgba(255,255,255,0.2)">#{{ str_pad($auc->id,4,'0',STR_PAD_LEFT) }}</div></td>
          <td style="font-size:17px;font-weight:700;color:#1a56db">€{{ number_format($auc->current_price??$auc->base_price??0,0,',','.') }}</td>
          <td style="color:rgba(255,255,255,0.4)">{{ $auc->total_bids??0 }}</td>
          <td><span class="badge badge-{{ $auc->status??'pending' }}">{{ $auc->status??'pending' }}</span></td>
          <td style="font-size:12px;color:rgba(255,255,255,0.3)">{{ \Carbon\Carbon::parse($auc->end_time??$auc->ends_at??now())->format('d/m/Y H:i') }}</td>
          <td><div style="display:flex;gap:4px">
            <a href="{{ route('auctions.show',$auc->id) }}" class="a av">Ver</a><a href="{{ route('admin.auctions.edit',$auc->id) }}" class="a av" style="background:#1a56db;color:#fff;">Editar</a>
            @if(($auc->status??'')==='pending')<form method="POST" action="{{ route('admin.approve',$auc->id) }}" style="display:inline">@csrf<button type="submit" class="a aa">Aprobar</button></form>@endif
            <form method="POST" action="{{ route('admin.destroy',$auc->id) }}" style="display:inline" onsubmit="return confirm('Eliminar?')">@csrf @method('DELETE')<button type="submit" class="a ad">Eliminar</button></form>
          </div></td>
        </tr>
        @empty
        <tr><td colspan="7"><div class="empty">Sin lotes. <a href="{{ route('admin.auctions.create') }}" style="color:#1a56db">Crear →</a></div></td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    <div class="box" id="pujas">
      <div class="bh"><span class="bt">Pujas Recientes</span><span class="bc">Últimas 20</span></div>
      @if(isset($recentBids)&&$recentBids->count()>0)
      <table>
        <thead><tr><th>Postor</th><th>Lote</th><th>Importe</th><th>Fecha</th></tr></thead>
        <tbody>
        @foreach($recentBids as $bid)
        <tr>
          <td><div style="font-weight:500">{{ $bid->user->name??'Anónimo' }}</div><div style="font-size:11px;color:rgba(255,255,255,0.2)">{{ $bid->user->email??'' }}</div></td>
          <td style="color:rgba(255,255,255,0.4)">{{ Str::limit($bid->auction->title??'—',35) }}</td>
          <td style="font-size:15px;font-weight:700;color:#1a56db">€{{ number_format($bid->amount,0,',','.') }}</td>
          <td style="font-size:12px;color:rgba(255,255,255,0.3)">{{ $bid->created_at->format('d/m H:i') }}</td>
        </tr>
        @endforeach
        </tbody>
      </table>
      @else<div class="empty">Sin pujas aún.</div>@endif
    </div>
    <div class="box" id="clientes">
      <div class="bh"><span class="bt">Clientes</span><span class="bc">{{ $totalUsers??0 }} usuarios</span></div>
      @if(isset($users)&&$users->count()>0)
      <table>
        <thead><tr><th>Nombre</th><th>Email</th><th>Pujas</th><th>Registro</th></tr></thead>
        <tbody>
        @foreach($users as $usr)
        <tr>
          <td style="font-weight:500">{{ $usr->name }}</td>
          <td style="color:rgba(255,255,255,0.4)">{{ $usr->email }}</td>
          <td style="color:rgba(255,255,255,0.4)">{{ $usr->bids_count??0 }}</td>
          <td style="font-size:12px;color:rgba(255,255,255,0.3)">{{ $usr->created_at->format('d/m/Y') }}</td>
        </tr>
        @endforeach
        </tbody>
      </table>
      @else<div class="empty">Sin usuarios aún.</div>@endif
    </div>
  </div>
</div>
</body>
</html>
