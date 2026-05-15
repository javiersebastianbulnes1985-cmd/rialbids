@extends('layouts.app')
@section('content')

@php $catActual = request('categoria',''); $busqueda = request('q',''); @endphp

<div style="background:#374151;padding:22px 24px;">
  <div style="max-width:1280px;margin:0 auto;display:flex;justify-content:space-between;align-items:center;">
    <div>
      <h1 style="font-size:22px;font-weight:700;color:#fff;margin:0;">Subastas Finalizadas</h1>
      <p style="font-size:13px;color:rgba(255,255,255,0.7);margin:5px 0 0;">{{ $finalizadas->total() }} lotes cerrados</p>
    </div>
    <a href="{{ route('home') }}" style="font-size:13px;color:rgba(255,255,255,0.8);text-decoration:none;">← Volver a subastas activas</a>
  </div>
</div>

<div style="max-width:1280px;margin:24px auto;padding:0 24px;display:flex;gap:24px;align-items:flex-start;">

  <div style="width:200px;flex-shrink:0;">
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">
      <div style="padding:14px 16px;border-bottom:1px solid #f3f4f6;">
        <p style="font-size:12px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.08em;margin:0;">Categorías</p>
      </div>
      <div style="padding:8px 0;">
        <a href="{{ route('auctions.finalizadas') }}"
           style="display:flex;justify-content:space-between;align-items:center;padding:9px 16px;text-decoration:none;font-size:13px;font-weight:{{ $catActual===''?'700':'500' }};color:{{ $catActual===''?'#1a56db':'#374151' }};background:{{ $catActual===''?'#eff6ff':'transparent' }};">
          <span>Todas</span>
          <span style="background:#f3f4f6;color:#6b7280;font-size:11px;font-weight:600;padding:2px 8px;border-radius:20px;">{{ $finalizadas->total() }}</span>
        </a>
        @foreach($categorias as $slug => $nombre)
          <a href="{{ route('auctions.finalizadas', ['categoria' => $slug]) }}"
             style="display:flex;justify-content:space-between;align-items:center;padding:9px 16px;text-decoration:none;font-size:13px;font-weight:{{ $catActual===$slug?'700':'500' }};color:{{ $catActual===$slug?'#1a56db':'#374151' }};background:{{ $catActual===$slug?'#eff6ff':'transparent' }};">
            <span>{{ $nombre }}</span>
          </a>
        @endforeach
      </div>
    </div>
  </div>

  <div style="flex:1;min-width:0;">

    <form method="GET" action="{{ route('auctions.finalizadas') }}" style="margin-bottom:20px;display:flex;gap:8px;">
      @if($catActual)<input type="hidden" name="categoria" value="{{ $catActual }}">@endif
      <input type="text" name="q" value="{{ $busqueda }}" placeholder="Buscar en finalizadas..."
             style="flex:1;padding:9px 14px;border:1px solid #e5e7eb;border-radius:8px;font-size:13px;outline:none;">
      <button type="submit" style="padding:9px 18px;background:#374151;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;">Buscar</button>
    </form>

    @if($finalizadas->isEmpty())
      <div style="text-align:center;padding:60px 0;color:#9ca3af;">
        <p style="font-size:16px;">No hay subastas finalizadas en esta categoría.</p>
        <a href="{{ route('auctions.finalizadas') }}" style="color:#1a56db;font-size:13px;">Ver todas →</a>
      </div>
    @else
      <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
        @foreach($finalizadas as $auction)
          @php
            $img = null;
            if(!empty($auction->image_path)) $img = asset('storage/'.$auction->image_path);
            elseif(!empty($auction->image_path_2)) $img = asset('storage/'.$auction->image_path_2);
            elseif(!empty($auction->video_url)){
              preg_match('/[?&]v=([^&]+)/i',$auction->video_url,$mm);
              if(!empty($mm[1])) $img = "https://img.youtube.com/vi/{$mm[1]}/hqdefault.jpg";
            }
            $cp = $auction->current_price ?? $auction->base_price ?? 0;
            $tb = $auction->total_bids ?? 0;
            $ef = $auction->end_time ?? $auction->ends_at ?? null;
          @endphp
          <a href="{{ route('auctions.show', $auction->id) }}"
             style="display:block;background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;text-decoration:none;opacity:0.85;transition:opacity .2s;"
             onmouseover="this.style.opacity='1'"
             onmouseout="this.style.opacity='0.85'">
            <div style="position:relative;aspect-ratio:4/3;background:#f3f4f6;overflow:hidden;display:flex;align-items:center;justify-content:center;">
              @if($img)
                <img src="{{ $img }}" alt="{{ $auction->title }}" style="width:100%;height:100%;object-fit:cover;filter:grayscale(30%);" loading="lazy">
              @else
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5">
                  <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/>
                </svg>
              @endif
              <div style="position:absolute;inset:0;background:rgba(0,0,0,0.25);display:flex;align-items:center;justify-content:center;">
                <span style="background:rgba(0,0,0,0.7);color:#fff;font-size:11px;font-weight:700;padding:4px 12px;border-radius:20px;letter-spacing:0.05em;">FINALIZADA</span>
              </div>
              <div style="position:absolute;top:8px;left:8px;">
                <span style="background:rgba(255,255,255,0.9);color:#6b7280;font-size:10px;font-weight:600;padding:2px 8px;border-radius:20px;">
                  {{ $categorias[$auction->lot_category] ?? 'General' }}
                </span>
              </div>
            </div>
            <div style="padding:12px 14px;">
              <h3 style="font-size:13px;font-weight:600;color:#374151;line-height:1.4;margin-bottom:8px;min-height:36px;">
                {{ Str::limit($auction->title, 50) }}
              </h3>
              <div style="display:flex;justify-content:space-between;align-items:flex-end;">
                <div>
                  <p style="font-size:10px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:1px;">Precio final</p>
                  <p style="font-size:18px;font-weight:700;color:#6b7280;">€{{ number_format($cp,0,',','.') }}</p>
                  <p style="font-size:11px;color:#9ca3af;">{{ $tb }} {{ $tb==1?'puja':'pujas' }}</p>
                </div>
                @if($ef)
                <div style="text-align:right;">
                  <p style="font-size:10px;color:#9ca3af;">Cerrada el</p>
                  <p style="font-size:12px;font-weight:600;color:#6b7280;">{{ \Carbon\Carbon::parse($ef)->format('d/m/Y') }}</p>
                </div>
                @endif
              </div>
            </div>
          </a>
        @endforeach
      </div>

      <div style="margin-top:30px;display:flex;justify-content:center;gap:6px;">
        @if($finalizadas->onFirstPage())
          <span style="padding:8px 14px;border:1px solid #e5e7eb;border-radius:8px;font-size:13px;color:#d1d5db;">← Anterior</span>
        @else
          <a href="{{ $finalizadas->previousPageUrl() }}" style="padding:8px 14px;border:1px solid #e5e7eb;border-radius:8px;font-size:13px;color:#374151;text-decoration:none;">← Anterior</a>
        @endif
        <span style="padding:8px 14px;background:#374151;color:#fff;border-radius:8px;font-size:13px;font-weight:600;">
          Página {{ $finalizadas->currentPage() }} de {{ $finalizadas->lastPage() }}
        </span>
        @if($finalizadas->hasMorePages())
          <a href="{{ $finalizadas->nextPageUrl() }}" style="padding:8px 14px;border:1px solid #e5e7eb;border-radius:8px;font-size:13px;color:#374151;text-decoration:none;">Siguiente →</a>
        @else
          <span style="padding:8px 14px;border:1px solid #e5e7eb;border-radius:8px;font-size:13px;color:#d1d5db;">Siguiente →</span>
        @endif
      </div>
    @endif
  </div>
</div>

@endsection
