@extends('layouts.app')
@section('content')
<style>
.tab-btn{background:none;border:none;padding:14px 24px;font-size:14px;font-weight:600;color:#6b7280;cursor:pointer;border-bottom:3px solid transparent;transition:all .2s;white-space:nowrap}
.tab-btn.active{color:#1a56db;border-bottom:3px solid #1a56db}
.tab-panel{display:none}
.tab-panel.active{display:block}
.compra-card{background:#fff;border:1px solid #e5e7eb;border-radius:16px;overflow:hidden;margin-bottom:16px;transition:box-shadow .2s}
.compra-card:hover{box-shadow:0 4px 20px rgba(0,0,0,0.08)}
.compra-card.pendiente{border-left:4px solid #f59e0b}
</style>
<div style="background:linear-gradient(135deg,#1e40af 0%,#4f46e5 50%,#7c3aed 100%);padding:40px 16px 80px">
  <div style="max-width:900px;margin:0 auto">
    <div style="display:flex;align-items:center;gap:20px;margin-bottom:36px">
      <div style="width:80px;height:80px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;border:3px solid rgba(255,255,255,0.4);flex-shrink:0;font-size:32px;font-weight:800;color:#fff">{{ strtoupper(substr($user->name,0,1)) }}</div>
      <div>
        <h1 style="font-size:26px;font-weight:800;color:#fff;margin:0">{{ $user->name }}</h1>
        <p style="font-size:13px;color:rgba(255,255,255,0.7);margin:6px 0 0">{{ $user->email }}</p>
        <span style="background:rgba(255,255,255,0.2);color:#fff;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;margin-top:8px;display:inline-block">Desde {{ $user->created_at->format('M Y') }}</span>
      </div>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px">
      <div style="background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.2);border-radius:16px;padding:20px;text-align:center">
        <p style="font-size:32px;font-weight:800;color:#fff;margin:0">{{ $bids->count() }}</p>
        <p style="font-size:11px;color:rgba(255,255,255,0.6);margin:6px 0 0;font-weight:700;text-transform:uppercase">Pujas</p>
      </div>
      <div style="background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.2);border-radius:16px;padding:20px;text-align:center">
        <p style="font-size:32px;font-weight:800;color:#fbbf24;margin:0">{{ $compras->count() }}</p>
        <p style="font-size:11px;color:rgba(255,255,255,0.6);margin:6px 0 0;font-weight:700;text-transform:uppercase">Compras</p>
      </div>
      <div style="background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.2);border-radius:16px;padding:20px;text-align:center">
        <p style="font-size:32px;font-weight:800;color:#34d399;margin:0">€{{ number_format($compras->sum('final_price') ?: $compras->sum('current_price'),0,',','.') }}</p>
        <p style="font-size:11px;color:rgba(255,255,255,0.6);margin:6px 0 0;font-weight:700;text-transform:uppercase">Gastado</p>
      </div>
    </div>
  </div>
</div>
<div style="background:#fff;border-bottom:1px solid #e5e7eb;position:sticky;top:0;z-index:10;box-shadow:0 2px 8px rgba(0,0,0,0.06)">
  <div style="max-width:900px;margin:0 auto;display:flex">
    <button class="tab-btn active" onclick="switchTab('compras',this)">🛍️ Mis Compras</button>
    <button class="tab-btn" onclick="switchTab('historial',this)">📋 Historial</button>
    <button class="tab-btn" onclick="switchTab('perfil',this)">👤 Mi Perfil</button>
  </div>
</div>
<div style="max-width:900px;margin:28px auto;padding:0 16px 60px">
  <div id="tab-compras" class="tab-panel active">
    @if($compras->isEmpty())
      <div style="background:#fff;border:2px dashed #e5e7eb;border-radius:20px;padding:60px;text-align:center">
        <div style="font-size:56px;margin-bottom:16px">🛍️</div>
        <p style="font-size:18px;font-weight:700;color:#111;margin:0 0 8px">Todavía no ganaste ninguna subasta</p>
        <p style="font-size:14px;color:#9ca3af;margin:0 0 28px">Participá en subastas para ver tus compras acá</p>
        <a href="{{ route('home') }}" style="background:linear-gradient(135deg,#1a56db,#4f46e5);color:#fff;padding:12px 28px;border-radius:10px;font-size:14px;font-weight:700;text-decoration:none">Explorar subastas →</a>
      </div>
    @else
      @foreach($compras as $compra)
      @php
        $deadline = $compra->updated_at->addDays(3);
        $h = max(0, now()->diffInHours($deadline, false));
        $d = max(0, now()->diffInDays($deadline, false));
        $pendiente = !in_array($compra->status, ['paid','shipped','delivered','completed']);
        $imgs = $compra->images ? (is_array($compra->images) ? $compra->images : json_decode($compra->images,true)) : [];
        $img = $imgs[0] ?? null;
      @endphp
      <div class="compra-card {{ $pendiente ? 'pendiente' : '' }}">
        <div style="display:flex">
          @if($img)
            <img src="/storage/{{ $img }}" style="width:130px;height:130px;object-fit:cover;flex-shrink:0">
          @else
            <div style="width:130px;height:130px;flex-shrink:0;background:linear-gradient(135deg,#eff6ff,#e0e7ff);display:flex;align-items:center;justify-content:center;font-size:36px">🏺</div>
          @endif
          <div style="padding:20px;flex:1">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px">
              <div>
                <a href="{{ route('auctions.show', $compra->id) }}" style="text-decoration:none">
                  <p style="font-size:15px;font-weight:700;color:#111;margin:0">{{ $compra->title }}</p>
                </a>
                <p style="font-size:12px;color:#9ca3af;margin:4px 0 12px">Lote #{{ str_pad($compra->id,4,'0',STR_PAD_LEFT) }}</p>
              </div>
              <p style="font-size:20px;font-weight:800;color:#111;margin:0;white-space:nowrap">€{{ number_format($compra->final_price ?? $compra->current_price,0,',','.') }}</p>
            </div>
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
              @if($compra->status === 'paid')
                <span style="background:#d1fae5;color:#065f46;padding:5px 12px;border-radius:20px;font-size:12px;font-weight:700">✓ Pagado</span>
              @elseif($compra->status === 'shipped')
                <span style="background:#eff6ff;color:#2563eb;padding:5px 12px;border-radius:20px;font-size:12px;font-weight:700">📦 Enviado</span>
                <form method="POST" action="{{ route('auctions.confirm', $compra->id) }}" style="display:inline">
                  @csrf
                  <button type="submit" style="background:#16a34a;color:#fff;border:none;border-radius:8px;padding:6px 14px;font-size:12px;font-weight:700;cursor:pointer">✓ Confirmar recepción</button>
                </form>
              @elseif(in_array($compra->status,['delivered','completed']))
                <span style="background:#d1fae5;color:#15803d;padding:5px 12px;border-radius:20px;font-size:12px;font-weight:700">✅ Completado</span>
              @else
                <span style="background:#fef9c3;color:#92400e;padding:5px 12px;border-radius:20px;font-size:12px;font-weight:700">⏳ Pago pendiente</span>
                @if($h > 0)
                  <span style="font-size:12px;color:#ef4444;font-weight:700">⏱ {{ $d > 0 ? $d.'d' : $h.'h' }} restantes</span>
                @endif
                <a href="{{ route('payment.checkout', $compra->id) }}" style="background:linear-gradient(135deg,#1a56db,#4f46e5);color:#fff;padding:7px 18px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none">💳 Pagar ahora</a>
              @endif
            </div>
          </div>
        </div>
      </div>
      @endforeach
    @endif
  </div>
  <div id="tab-historial" class="tab-panel">
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;overflow:hidden">
      <div style="padding:16px 20px;border-bottom:1px solid #e5e7eb;display:flex;justify-content:space-between;align-items:center">
        <h2 style="font-size:15px;font-weight:700;color:#111;margin:0">Historial de pujas</h2>
        <span style="font-size:13px;color:#9ca3af">{{ $bids->count() }} total</span>
      </div>
      @if($bids->isEmpty())
        <div style="padding:48px;text-align:center;color:#9ca3af"><p>Todavía no hiciste ninguna puja.</p></div>
      @else
        <div style="overflow-x:auto">
          <table style="width:100%;border-collapse:collapse;min-width:320px">
            <thead style="background:#f9fafb">
              <tr>
                <th style="padding:10px 16px;text-align:left;font-size:11px;color:#6b7280;font-weight:600">Lote</th>
                <th style="padding:10px 16px;text-align:left;font-size:11px;color:#6b7280;font-weight:600">Tu puja</th>
                <th style="padding:10px 16px;text-align:left;font-size:11px;color:#6b7280;font-weight:600">Estado</th>
                <th style="padding:10px 16px;text-align:left;font-size:11px;color:#6b7280;font-weight:600">Fecha</th>
                <th style="padding:10px 16px"></th>
              </tr>
            </thead>
            <tbody>
              @foreach($bids as $bid)
              <tr style="border-top:1px solid #f3f4f6">
                <td style="padding:12px 16px">
                  <p style="font-size:13px;font-weight:600;color:#111;margin:0">{{ Str::limit($bid->auction->title ?? '—', 28) }}</p>
                  <p style="font-size:11px;color:#9ca3af;margin:2px 0 0">#{{ str_pad($bid->auction_id,4,'0',STR_PAD_LEFT) }}</p>
                </td>
                <td style="padding:12px 16px">
                  <p style="font-size:14px;font-weight:700;color:#1a56db;margin:0">€{{ number_format($bid->amount,0,',','.') }}</p>
                </td>
                <td style="padding:12px 16px">
                  @if($bid->auction && $bid->auction->current_price == $bid->amount && $bid->auction->status === 'active')
                    <span style="background:#d1fae5;color:#065f46;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600">Ganando</span>
                  @elseif($bid->auction && in_array($bid->auction->status,['finished','paid','shipped','delivered','completed']) && $bid->auction->winner_id === auth()->id())
                    <span style="background:#eff6ff;color:#2563eb;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600">🏆 Ganado</span>
                  @else
                    <span style="background:#fee2e2;color:#991b1b;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600">Superado</span>
                  @endif
                </td>
                <td style="padding:12px 16px;font-size:11px;color:#9ca3af">{{ $bid->created_at->format('d/m/Y H:i') }}</td>
                <td style="padding:12px 16px">
                  @if($bid->auction)
                    <a href="{{ route('auctions.show', $bid->auction_id) }}" style="font-size:12px;color:#1a56db;text-decoration:none;font-weight:600">Ver →</a>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
  <div id="tab-perfil" class="tab-panel">
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:32px">
      <h2 style="font-size:16px;font-weight:700;color:#111;margin:0 0 24px">Mi Perfil</h2>
      <div style="display:grid;gap:20px">
        <div style="padding:16px;background:#f9fafb;border-radius:10px">
          <p style="font-size:11px;color:#9ca3af;margin:0 0 4px;font-weight:700;text-transform:uppercase">Nombre</p>
          <p style="font-size:15px;color:#111;margin:0;font-weight:600">{{ $user->name }}</p>
        </div>
        <div style="padding:16px;background:#f9fafb;border-radius:10px">
          <p style="font-size:11px;color:#9ca3af;margin:0 0 4px;font-weight:700;text-transform:uppercase">Email</p>
          <p style="font-size:15px;color:#111;margin:0;font-weight:600">{{ $user->email }}</p>
        </div>
        <div style="padding:16px;background:#f9fafb;border-radius:10px">
          <p style="font-size:11px;color:#9ca3af;margin:0 0 4px;font-weight:700;text-transform:uppercase">Miembro desde</p>
          <p style="font-size:15px;color:#111;margin:0;font-weight:600">{{ $user->created_at->format('d/m/Y') }}</p>
        </div>
      </div>
      <div style="margin-top:32px;padding-top:24px;border-top:1px solid #f3f4f6">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" style="background:#fee2e2;color:#991b1b;border:none;border-radius:8px;padding:10px 20px;font-size:14px;font-weight:600;cursor:pointer">→ Cerrar sesión</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
function switchTab(tab,btn){
  document.querySelectorAll('.tab-panel').forEach(p=>p.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('active'));
  document.getElementById('tab-'+tab).classList.add('active');
  btn.classList.add('active');
}
</script>
@endsection
