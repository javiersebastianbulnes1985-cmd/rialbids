@extends('layouts.app')
@section('title','Cómo comprar — RialBids')
@section('content')
<style>
.page-wrap{max-width:800px;margin:48px auto;padding:0 24px}
.page-tag{display:inline-block;background:#f3f4f6;color:#374151;font-size:11px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;padding:4px 12px;border-radius:20px;margin-bottom:14px}
.page-h1{font-size:28px;font-weight:700;color:#111;margin:0 0 8px}
.page-desc{font-size:14px;color:#9ca3af;display:block;margin-bottom:40px;padding-bottom:32px;border-bottom:1px solid #e5e7eb}
.steps{display:flex;flex-direction:column;gap:12px;margin-bottom:32px}
.step{display:flex;gap:20px;align-items:flex-start;padding:20px;border:1px solid #e5e7eb;border-radius:10px}
.step-num{width:36px;height:36px;background:#f3f4f6;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:15px;font-weight:700;color:#374151}
.step-h{font-size:14px;font-weight:600;color:#111;margin:0 0 6px}
.step-p{font-size:13px;color:#6b7280;line-height:1.6;margin:0}
.cta-wrap{background:#1a56db;border-radius:12px;padding:28px;text-align:center}
.cta-h{font-size:17px;font-weight:700;color:#fff;margin:0 0 8px}
.cta-p{font-size:14px;color:rgba(255,255,255,0.8);margin:0 0 16px}
.cta-btn{display:inline-block;background:#fff;color:#1a56db;padding:12px 28px;border-radius:8px;font-weight:600;text-decoration:none;font-size:14px}
</style>
<div class="page-wrap">
  <div class="page-tag">Comprar</div>
  <h1 class="page-h1">Cómo comprar en RialBids</h1>
  <span class="page-desc">Todo lo que necesitás saber para pujar y ganar lotes.</span>
  <div class="steps">
    <div class="step"><div class="step-num">1</div><div><p class="step-h">Creá tu cuenta</p><p class="step-p">Registrate gratis en RialBids. Solo necesitás un email y contraseña. La verificación es instantánea.</p></div></div>
    <div class="step"><div class="step-num">2</div><div><p class="step-h">Explorá los lotes</p><p class="step-p">Navegá por categorías o usá el buscador. Cada lote tiene fotos, descripción, precio actual y tiempo restante.</p></div></div>
    <div class="step"><div class="step-num">3</div><div><p class="step-h">Realizá tu puja</p><p class="step-p">Ingresá el monto que querés ofertar. Tiene que ser mayor al precio actual más el incremento mínimo. Podés usar los botones de puja rápida.</p></div></div>
    <div class="step"><div class="step-num">4</div><div><p class="step-h">Subastas seguras</p><p class="step-p">Nuestro sistema garantiza que todos los compradores tengan las mismas oportunidades hasta el último momento de la subasta.</p></div></div>
    <div class="step"><div class="step-num">5</div><div><p class="step-h">Si ganás</p><p class="step-p">Al finalizar la subasta, el postor más alto gana el lote. Te contactaremos para coordinar el pago y envío.</p></div></div>
  </div>
  <div class="cta-wrap">
    <h2 class="cta-h">¿Listo para empezar?</h2>
    <p class="cta-p">Explorá los lotes activos ahora mismo.</p>
    <a href="{{ route('home') }}" class="cta-btn">Ver subastas →</a>
  </div>
</div>
@endsection
