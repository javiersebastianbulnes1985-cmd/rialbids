@extends('layouts.app')
@section('title','Cómo vender en RialBids')
@section('content')
<style>
.page-wrap{max-width:800px;margin:48px auto;padding:0 24px}
.page-tag{display:inline-block;background:#f3f4f6;color:#374151;font-size:11px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;padding:4px 12px;border-radius:20px;margin-bottom:14px}
.page-h1{font-size:28px;font-weight:700;color:#111;margin:0 0 8px}
.page-desc{font-size:14px;color:#9ca3af;display:block;margin-bottom:32px;padding-bottom:28px;border-bottom:1px solid #e5e7eb}
.banner-green{background:#f0fdf4;border:1px solid #86efac;border-radius:12px;padding:20px 24px;margin-bottom:28px;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap}
.banner-green-h{font-size:15px;font-weight:700;color:#166534;margin:0 0 4px}
.banner-green-p{font-size:13px;color:#16a34a;margin:0}
.banner-green-btn{background:#166534;color:#fff;padding:10px 20px;border-radius:6px;font-size:13px;font-weight:600;text-decoration:none;white-space:nowrap}
.steps{display:flex;flex-direction:column;gap:12px;margin-bottom:28px}
.step{display:flex;gap:20px;align-items:flex-start;padding:18px 20px;border:1px solid #e5e7eb;border-radius:10px}
.step-num{width:36px;height:36px;background:#f3f4f6;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:15px;font-weight:700;color:#374151}
.step-num.green{background:#dcfce7;color:#166534}
.step-h{font-size:14px;font-weight:600;color:#111;margin:0 0 6px}
.step-p{font-size:13px;color:#6b7280;line-height:1.6;margin:0}
.cta-wrap{background:#111827;border-radius:12px;padding:28px;text-align:center}
.cta-h{font-size:17px;font-weight:700;color:#fff;margin:0 0 8px}
.cta-p{font-size:14px;color:rgba(255,255,255,0.7);margin:0 0 16px}
.cta-btn{display:inline-block;background:#1a56db;color:#fff;padding:12px 28px;border-radius:8px;font-weight:600;text-decoration:none;font-size:14px}
</style>
<div class="page-wrap">
  <div class="page-tag">Vender</div>
  <h1 class="page-h1">Vendé en RialBids</h1>
  <span class="page-desc">¿Tenés objetos que ya no usás? Vendelos en Europa.</span>
  <div class="banner-green">
    <div>
      <p class="banner-green-h">Comisión baja. Sin cuotas mensuales.</p>
      <p class="banner-green-p">Solo pagás cuando vendés. Los detalles los ves al registrarte.</p>
    </div>
    <a href="/seller-request" class="banner-green-btn">Empezar a vender</a>
  </div>
  <div class="steps">
    <div class="step"><div class="step-num">1</div><div><p class="step-h">Subí tu lote</p><p class="step-p">Registrate como vendedor y subí fotos y descripción. Nuestro equipo lo revisa antes de publicarlo.</p></div></div>
    <div class="step"><div class="step-num">2</div><div><p class="step-h">Subasta de 7 días</p><p class="step-p">Compradores de toda Europa compiten. El anti-sniping garantiza subastas justas.</p></div></div>
    <div class="step"><div class="step-num">3</div><div><p class="step-h">El comprador paga</p><p class="step-p">El ganador paga en 3 días. El dinero queda en custodia hasta confirmar la entrega.</p></div></div>
    <div class="step"><div class="step-num green">4</div><div><p class="step-h">Enviás y cobrás</p><p class="step-p">Enviás en 10 días. Al confirmar la entrega el pago llega a tu cuenta automáticamente.</p></div></div>
  </div>
  <div class="cta-wrap">
    <h2 class="cta-h">¿Listo para empezar?</h2>
    <p class="cta-p">Registrate y subí tu primer lote hoy.</p>
    <a href="/seller-request" class="cta-btn">Empezar a vender en RialBids</a>
  </div>
</div>
@endsection
