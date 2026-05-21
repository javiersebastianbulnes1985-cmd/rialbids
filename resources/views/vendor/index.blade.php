@extends('layouts.app')
@section('content')
<div style="max-width:1100px;margin:40px auto;padding:0 20px;">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
    <h1 style="font-size:22px;font-weight:700;color:#111827;margin:0;">Mi Panel de Vendedor</h1>
    <a href="{{ route('vendor.create') }}"
       style="padding:10px 20px;background:#111827;color:#fff;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;">
      + Nuevo lote
    </a>
  </div>

  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:32px;">
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:20px;text-align:center;">
      <p style="font-size:28px;font-weight:700;color:#111827;margin:0;">{{ $stats['total'] }}</p>
      <p style="font-size:12px;color:#6b7280;margin-top:4px;">Total lotes</p>
    </div>
    <div style="background:#fff;border:1px solid #fbbf24;border-radius:10px;padding:20px;text-align:center;">
      <p style="font-size:28px;font-weight:700;color:#f59e0b;margin:0;">{{ $stats['pendiente'] }}</p>
      <p style="font-size:12px;color:#6b7280;margin-top:4px;">Pendientes</p>
    </div>
    <div style="background:#fff;border:1px solid #86efac;border-radius:10px;padding:20px;text-align:center;">
      <p style="font-size:28px;font-weight:700;color:#16a34a;margin:0;">{{ $stats['activo'] }}</p>
      <p style="font-size:12px;color:#6b7280;margin-top:4px;">Activos</p>
    </div>
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:20px;text-align:center;">
      <p style="font-size:28px;font-weight:700;color:#6b7280;margin:0;">{{ $stats['finalizado'] }}</p>
      <p style="font-size:12px;color:#6b7280;margin-top:4px;">Finalizados</p>
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

  @if(!auth()->user()->stripe_onboarding_complete)
    <div style="background:#fffbeb;border:1px solid #fbbf24;color:#92400e;padding:16px;border-radius:8px;margin-bottom:20px;font-size:13px;">
      ⚠️ Tu cuenta de pagos no está configurada.
      <a href="{{ route('vendor.stripe.onboarding') }}" style="color:#92400e;font-weight:700;text-decoration:underline;">Configurá tu cuenta Stripe aquí</a>.
    </div>
  @endif

  @if($auctions->isEmpty())
    <div style="text-align:center;padding:60px 0;color:#9ca3af;">
      <p style="font-size:16px;">No tenés lotes todavía.</p>
      <a href="{{ route('vendor.create') }}" style="color:#1a56db;font-size:13px;">Crear tu primer lote →</a>
    </div>
  @else
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">
      <table style="width:100%;border-collapse:collapse;">
        <thead>
          <tr style="background:#f9fafb;border-bottom:1px solid #e5e7eb;">
            <th style="padding:12px 16px;text-align:left;font-size:12px;color:#6b7280;font-weight:600;text-transform:uppercase;">Lote</th>
            <th style="padding:12px 16px;text-align:center;font-size:12px;color:#6b7280;font-weight:600;text-transform:uppercase;">Estado</th>
            <th style="padding:12px 16px;text-align:right;font-size:12px;color:#6b7280;font-weight:600;text-transform:uppercase;">Precio</th>
            <th style="padding:12px 16px;text-align:center;font-size:12px;color:#6b7280;font-weight:600;text-transform:uppercase;">Pujas</th>
            <th style="padding:12px 16px;text-align:right;font-size:12px;color:#6b7280;font-weight:600;text-transform:uppercase;">Cierra</th>
            <th style="padding:12px 16px;text-align:center;font-size:12px;color:#6b7280;font-weight:600;text-transform:uppercase;">Envío</th>
          </tr>
        </thead>
        <tbody>
          @foreach($auctions as $lot)
            @php
              $img = null;
              if(!empty($lot->image_path)) $img = asset('storage/'.$lot->image_path);
              $cp = $lot->current_price ?? $lot->base_price ?? 0;
              $statusColor = match($lot->status) {
                'active'    => ['bg'=>'#f0fdf4','color'=>'#16a34a','label'=>'Activo'],
                'pending'   => ['bg'=>'#fffbeb','color'=>'#d97706','label'=>'Pendiente'],
                'finished'  => ['bg'=>'#f3f4f6','color'=>'#6b7280','label'=>'Finalizado'],
                'paid'      => ['bg'=>'#eff6ff','color'=>'#2563eb','label'=>'Pagado ✓'],
                'shipped'   => ['bg'=>'#f0fdf4','color'=>'#059669','label'=>'Enviado 📦'],
                'delivered' => ['bg'=>'#f0fdf4','color'=>'#16a34a','label'=>'Entregado ✓'],
                'completed' => ['bg'=>'#f0fdf4','color'=>'#15803d','label'=>'Completado ✓'],
                default     => ['bg'=>'#f3f4f6','color'=>'#6b7280','label'=>ucfirst($lot->status)],
              };
            @endphp
            <tr style="border-bottom:1px solid #f3f4f6;">
              <td style="padding:14px 16px;">
                <a href="{{ route('auctions.show', $lot->id) }}" style="display:flex;align-items:center;gap:12px;text-decoration:none;">
                  @if($img)
                    <img src="{{ $img }}" style="width:48px;height:48px;object-fit:cover;border-radius:6px;border:1px solid #e5e7eb;">
                  @else
                    <div style="width:48px;height:48px;background:#f3f4f6;border-radius:6px;display:flex;align-items:center;justify-content:center;">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/></svg>
                    </div>
                  @endif
                  <div>
                    <p style="font-size:13px;font-weight:600;color:#111827;margin:0;">{{ Str::limit($lot->title, 40) }}</p>
                    <p style="font-size:11px;color:#9ca3af;margin:2px 0 0;">Lote #{{ str_pad($lot->id,4,'0',STR_PAD_LEFT) }}</p>
                  </div>
                </a>
              </td>
              <td style="padding:14px 16px;text-align:center;">
                <span style="background:{{ $statusColor['bg'] }};color:{{ $statusColor['color'] }};font-size:11px;font-weight:600;padding:4px 10px;border-radius:20px;">
                  {{ $statusColor['label'] }}
                </span>
              </td>
              <td style="padding:14px 16px;text-align:right;font-size:14px;font-weight:700;color:{{ $lot->total_bids>0?'#16a34a':'#111827' }};">
                €{{ number_format($cp,0,',','.') }}
              </td>
              <td style="padding:14px 16px;text-align:center;font-size:13px;color:#6b7280;">
                {{ $lot->total_bids ?? 0 }}
              </td>
              <td style="padding:14px 16px;text-align:right;font-size:12px;color:#6b7280;">
                @if($lot->end_time)
                  {{ \Carbon\Carbon::parse($lot->end_time)->format('d/m/Y H:i') }}
                @else
                  —
                @endif
              </td>
              <td style="padding:14px 16px;text-align:center;">
                @if($lot->status === 'paid')
                  <form method="POST" action="{{ route('vendor.auctions.ship', $lot->id) }}">
                    @csrf
                    <input type="text" name="tracking_number" placeholder="Nº tracking" required
                      style="border:1px solid #d1d5db;border-radius:6px;padding:4px 8px;font-size:12px;width:130px;display:block;margin-bottom:4px;">
                    <button type="submit"
                      style="background:#111827;color:#fff;border:none;border-radius:6px;padding:5px 12px;font-size:12px;cursor:pointer;width:100%;">
                      📦 Marcar enviado
                    </button>
                  </form>
                @elseif($lot->status === 'shipped')
                  <span style="font-size:12px;color:#059669;">📦 {{ $lot->tracking_number }}</span>
                @else
                  —
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>
@endsection
