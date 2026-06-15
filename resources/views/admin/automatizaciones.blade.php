@extends('layouts.app')
@section('content')
<div style="max-width:1000px;margin:0 auto;padding:24px 16px">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px">
    <h1 style="font-size:22px;font-weight:700;color:#111827;margin:0">Automatizaciones</h1>
    <a href="{{ route('admin.index') }}" style="font-size:13px;color:#6b7280;text-decoration:none">Volver al panel</a>
  </div>
  <p style="font-size:13px;color:#6b7280;margin:0 0 24px">Emails automaticos de la plataforma y disparo manual.</p>

  @if(session('success'))<div style="background:#ecfdf5;border:1px solid #a7f3d0;color:#065f46;padding:12px 16px;border-radius:8px;font-size:14px;margin-bottom:16px">{{ session('success') }}</div>@endif
  @if(session('error'))<div style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b;padding:12px 16px;border-radius:8px;font-size:14px;margin-bottom:16px">{{ session('error') }}</div>@endif

  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:24px">
    <div style="background:#f5f3ef;border-radius:10px;padding:16px">
      <div style="font-size:12px;color:#6b7280;margin-bottom:4px">Vendedores sin lotes</div>
      <div style="font-size:26px;font-weight:700;color:#1a3a6b">{{ $vendedoresSinLotes }}</div>
    </div>
    <div style="background:#f5f3ef;border-radius:10px;padding:16px">
      <div style="font-size:12px;color:#6b7280;margin-bottom:4px">Vendedores sin Stripe</div>
      <div style="font-size:26px;font-weight:700;color:#1a3a6b">{{ $vendedoresSinStripe }}</div>
    </div>
    <div style="background:#f5f3ef;border-radius:10px;padding:16px">
      <div style="font-size:12px;color:#6b7280;margin-bottom:4px">Compradores registrados</div>
      <div style="font-size:26px;font-weight:700;color:#1a3a6b">{{ $compradoresSinPujas }}</div>
    </div>
  </div>

  @foreach($automatizaciones as $a)
  <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:18px 20px;margin-bottom:12px">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:16px">
      <div style="flex:1">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px">
          <span style="font-size:15px;font-weight:700;color:#111827">{{ $a['nombre'] }}</span>
          <span style="font-size:11px;color:#8a6820;background:#fef9ec;padding:2px 8px;border-radius:20px">{{ $a['idiomas'] }}</span>
        </div>
        <p style="font-size:13px;color:#6b7280;margin:0 0 4px">{{ $a['descripcion'] }}</p>
        @if($a['pendientes'] !== null)
        <p style="font-size:13px;color:#1a3a6b;margin:0 0 8px;font-weight:600">{{ $a['pendientes'] }} {{ $a['etiqueta'] }}</p>
        @if($a['accion'])
        <a href="{{ route('admin.automatizaciones.preview', str_replace('invitacion_vendedores','invitacion_publicar',$a['accion'])) }}" target="_blank" style="font-size:12px;color:#c9a84c;text-decoration:none">Ver ejemplo del email &rarr;</a>
        @endif
        @else
        <p style="font-size:12px;color:#9ca3af;margin:0">{{ $a['etiqueta'] }}</p>
        @endif
      </div>
      <div>
        @if($a['accion'])
        <form method="POST" action="{{ route('admin.automatizaciones.disparar') }}">
          @csrf
          <input type="hidden" name="accion" value="{{ $a['accion'] }}">
          <button type="submit" onclick="return confirm('Enviar este email a los {{ $a['pendientes'] }} {{ $a['etiqueta'] }}?')" {{ $a['pendientes'] == 0 ? 'disabled' : '' }} style="font-size:13px;background:{{ $a['pendientes'] == 0 ? '#d1d5db' : '#1a3a6b' }};color:#fff;padding:8px 16px;border-radius:8px;border:none;cursor:{{ $a['pendientes'] == 0 ? 'not-allowed' : 'pointer' }};font-weight:600;white-space:nowrap">Enviar ahora</button>
        </form>
        @else
        <span style="font-size:11px;color:#9ca3af">Automatico</span>
        @endif
      </div>
    </div>
  </div>
  @endforeach
</div>
@endsection
