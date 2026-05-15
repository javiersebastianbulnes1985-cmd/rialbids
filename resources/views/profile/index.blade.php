@extends('layouts.app')
@section('title','Mi Perfil — RialBids')
@section('content')

<div style="max-width:900px;margin:40px auto;padding:0 24px;">

  <div style="background:#1a56db;border-radius:12px;padding:28px;margin-bottom:24px;display:flex;align-items:center;gap:20px;">
    <div style="width:64px;height:64px;border-radius:50%;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2">
        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
      </svg>
    </div>
    <div>
      <h1 style="font-size:20px;font-weight:700;color:#fff;margin:0;">{{ $user->name }}</h1>
      <p style="font-size:13px;color:rgba(255,255,255,0.7);margin:4px 0 0;">{{ $user->email }}</p>
      <p style="font-size:12px;color:rgba(255,255,255,0.5);margin:4px 0 0;">Miembro desde {{ $user->created_at->format('M Y') }}</p>
    </div>
    <div style="margin-left:auto;text-align:right;">
      <div style="font-size:28px;font-weight:700;color:#fff;">{{ $bids->count() }}</div>
      <div style="font-size:12px;color:rgba(255,255,255,0.6);">Pujas realizadas</div>
    </div>
  </div>

  @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #86efac;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:13px;">
      ✓ {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div style="background:#fef2f2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:13px;">
      ✗ {{ session('error') }}
    </div>
  @endif

  <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
    <div style="padding:16px 20px;border-bottom:1px solid #f3f4f6;display:flex;justify-content:space-between;align-items:center;">
      <h2 style="font-size:15px;font-weight:600;color:#111;">Historial de pujas</h2>
      <span style="font-size:13px;color:#9ca3af;">{{ $bids->count() }} total</span>
    </div>

    @if($bids->isEmpty())
      <div style="padding:48px;text-align:center;color:#9ca3af;">
        <p style="font-size:15px;">Todavía no hiciste ninguna puja.</p>
        <a href="{{ route('home') }}" style="color:#1a56db;font-size:13px;margin-top:8px;display:inline-block;">Ver subastas →</a>
      </div>
    @else
      <table style="width:100%;border-collapse:collapse;">
        <thead style="background:#f9fafb;">
          <tr>
            <th style="padding:12px 20px;text-align:left;font-size:12px;color:#6b7280;font-weight:600;">Lote</th>
            <th style="padding:12px 20px;text-align:left;font-size:12px;color:#6b7280;font-weight:600;">Tu puja</th>
            <th style="padding:12px 20px;text-align:left;font-size:12px;color:#6b7280;font-weight:600;">Precio actual</th>
            <th style="padding:12px 20px;text-align:left;font-size:12px;color:#6b7280;font-weight:600;">Estado</th>
            <th style="padding:12px 20px;text-align:left;font-size:12px;color:#6b7280;font-weight:600;">Fecha</th>
            <th style="padding:12px 20px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($bids as $bid)
          <tr style="border-top:1px solid #f3f4f6;">
            <td style="padding:14px 20px;">
              <p style="font-size:13px;font-weight:600;color:#111;">{{ Str::limit($bid->auction->title ?? '—', 40) }}</p>
              <p style="font-size:11px;color:#9ca3af;">#{{ str_pad($bid->auction_id, 4, '0', STR_PAD_LEFT) }}</p>
            </td>
            <td style="padding:14px 20px;">
              <p style="font-size:14px;font-weight:700;color:#1a56db;">€{{ number_format($bid->amount, 0, ',', '.') }}</p>
            </td>
            <td style="padding:14px 20px;">
              <p style="font-size:13px;color:#374151;">€{{ number_format($bid->auction->current_price ?? 0, 0, ',', '.') }}</p>
            </td>
            <td style="padding:14px 20px;">
              @if($bid->auction && $bid->auction->status === 'shipped' && $bid->auction->winner_id === auth()->id())
                <span style="background:#eff6ff;color:#2563eb;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;">📦 Enviado</span>
              @elseif($bid->auction && $bid->auction->status === 'delivered' && $bid->auction->winner_id === auth()->id())
                <span style="background:#f0fdf4;color:#16a34a;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;">✓ Entregado</span>
              @elseif($bid->auction && $bid->auction->status === 'completed')
                <span style="background:#f0fdf4;color:#15803d;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;">✓ Completado</span>
              @elseif($bid->auction && $bid->auction->current_price == $bid->amount)
                <span style="background:#d1fae5;color:#065f46;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;">Ganando</span>
              @else
                <span style="background:#fee2e2;color:#991b1b;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;">Superado</span>
              @endif
            </td>
            <td style="padding:14px 20px;font-size:12px;color:#9ca3af;">
              {{ $bid->created_at->format('d/m/Y H:i') }}
            </td>
            <td style="padding:14px 20px;">
              @if($bid->auction && $bid->auction->status === 'shipped' && $bid->auction->winner_id === auth()->id())
                <form method="POST" action="{{ route('auctions.confirm', $bid->auction_id) }}">
                  @csrf
                  <button type="submit"
                    style="background:#16a34a;color:#fff;border:none;border-radius:6px;padding:6px 12px;font-size:12px;cursor:pointer;font-weight:600;">
                    ✓ Confirmar recepción
                  </button>
                </form>
              @elseif($bid->auction)
                <a href="{{ route('auctions.show', $bid->auction_id) }}"
                   style="font-size:12px;color:#1a56db;text-decoration:none;font-weight:600;">Ver →</a>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
</div>

@endsection

