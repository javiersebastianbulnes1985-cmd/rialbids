@extends('layouts.app')
@section('title','Cómo comprar — RialBids')
@section('content')
<div style="max-width:800px;margin:48px auto;padding:0 24px;">

  <h1 style="font-size:28px;font-weight:700;color:#111;margin-bottom:8px;">Cómo comprar en RialBids</h1>
  <p style="font-size:15px;color:#6b7280;margin-bottom:40px;">Todo lo que necesitás saber para pujar y ganar lotes.</p>

  <div style="display:flex;flex-direction:column;gap:24px;">

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:24px;display:flex;gap:20px;align-items:flex-start;">
      <div style="width:40px;height:40px;background:#eff6ff;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:18px;">1</div>
      <div>
        <h3 style="font-size:16px;font-weight:600;color:#111;margin-bottom:6px;">Creá tu cuenta</h3>
        <p style="font-size:14px;color:#6b7280;line-height:1.6;">Registrate gratis en RialBids. Solo necesitás un email y contraseña. La verificación es instantánea.</p>
      </div>
    </div>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:24px;display:flex;gap:20px;align-items:flex-start;">
      <div style="width:40px;height:40px;background:#eff6ff;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:18px;">2</div>
      <div>
        <h3 style="font-size:16px;font-weight:600;color:#111;margin-bottom:6px;">Explorá los lotes</h3>
        <p style="font-size:14px;color:#6b7280;line-height:1.6;">Navegá por categorías o usá el buscador. Cada lote tiene fotos, descripción, precio actual y tiempo restante.</p>
      </div>
    </div>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:24px;display:flex;gap:20px;align-items:flex-start;">
      <div style="width:40px;height:40px;background:#eff6ff;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:18px;">3</div>
      <div>
        <h3 style="font-size:16px;font-weight:600;color:#111;margin-bottom:6px;">Realizá tu puja</h3>
        <p style="font-size:14px;color:#6b7280;line-height:1.6;">Ingresá el monto que querés ofertar. Tiene que ser mayor al precio actual más el incremento mínimo. Podés usar los botones de puja rápida.</p>
      </div>
    </div>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:24px;display:flex;gap:20px;align-items:flex-start;">
      <div style="width:40px;height:40px;background:#eff6ff;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:18px;">4</div>
      <div>
        <h3 style="font-size:16px;font-weight:600;color:#111;margin-bottom:6px;">Anti-sniping activo</h3>
        <p style="font-size:14px;color:#6b7280;line-height:1.6;">Si alguien puja en los últimos 2 minutos, el tiempo se extiende automáticamente 2 minutos más. Así todos tienen la misma oportunidad.</p>
      </div>
    </div>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:24px;display:flex;gap:20px;align-items:flex-start;">
      <div style="width:40px;height:40px;background:#eff6ff;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:18px;">5</div>
      <div>
        <h3 style="font-size:16px;font-weight:600;color:#111;margin-bottom:6px;">Si ganás</h3>
        <p style="font-size:14px;color:#6b7280;line-height:1.6;">Al finalizar la subasta, el postor más alto gana el lote. Te contactaremos para coordinar el pago y envío. La comisión de la plataforma es 9% + €3.</p>
      </div>
    </div>

  </div>

  <div style="background:#1a56db;border-radius:12px;padding:28px;margin-top:32px;text-align:center;">
    <h2 style="font-size:18px;font-weight:700;color:#fff;margin-bottom:8px;">¿Listo para empezar?</h2>
    <p style="font-size:14px;color:rgba(255,255,255,0.8);margin-bottom:16px;">Explorá los lotes activos ahora mismo.</p>
    <a href="{{ route('home') }}" style="display:inline-block;background:#fff;color:#1a56db;padding:12px 28px;border-radius:8px;font-weight:600;text-decoration:none;font-size:14px;">Ver subastas →</a>
  </div>

</div>
@endsection
