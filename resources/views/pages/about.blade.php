@extends('layouts.app')
@section('title','Quiénes somos — RialBids')
@section('content')
<style>
.page-wrap{max-width:800px;margin:48px auto;padding:0 24px}
.page-tag{display:inline-block;background:#f3f4f6;color:#374151;font-size:11px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;padding:4px 12px;border-radius:20px;margin-bottom:14px}
.page-h1{font-size:28px;font-weight:700;color:#111;margin:0 0 8px}
.page-desc{font-size:14px;color:#9ca3af;display:block;margin-bottom:32px;padding-bottom:28px;border-bottom:1px solid #e5e7eb}
.mision{border:1px solid #e5e7eb;border-radius:12px;padding:28px;margin-bottom:24px}
.mision h2{font-size:16px;font-weight:600;color:#111;margin:0 0 14px}
.mision p{font-size:14px;color:#6b7280;line-height:1.8;margin:0 0 12px}
.mision p:last-child{margin:0}
.stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:24px}
.stat{border:1px solid #e5e7eb;border-radius:12px;padding:20px;text-align:center}
.stat-num{font-size:28px;font-weight:700;color:#111;margin-bottom:4px}
.stat-label{font-size:13px;font-weight:600;color:#374151;margin-bottom:2px}
.stat-sub{font-size:12px;color:#9ca3af}
.steps{display:flex;flex-direction:column;gap:12px;margin-bottom:24px}
.step{display:flex;gap:16px;align-items:flex-start;padding:18px 20px;border:1px solid #e5e7eb;border-radius:10px}
.step-num{width:32px;height:32px;background:#f3f4f6;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:13px;font-weight:700;color:#374151}
.step-h{font-size:14px;font-weight:600;color:#111;margin:0 0 4px}
.step-p{font-size:13px;color:#6b7280;margin:0;line-height:1.6}
.cta-wrap{background:#111827;border-radius:12px;padding:28px;text-align:center}
.cta-h{font-size:17px;font-weight:700;color:#fff;margin:0 0 8px}
.cta-p{font-size:14px;color:rgba(255,255,255,0.7);margin:0 0 16px}
.cta-btns{display:flex;gap:12px;justify-content:center;flex-wrap:wrap}
.cta-btn-blue{background:#1a56db;color:#fff;padding:12px 24px;border-radius:6px;font-size:14px;font-weight:600;text-decoration:none}
.cta-btn-ghost{background:rgba(255,255,255,0.1);color:#fff;padding:12px 24px;border-radius:6px;font-size:14px;font-weight:600;text-decoration:none}
</style>
<div class="page-wrap">
  <div class="page-tag">Nosotros</div>
  <h1 class="page-h1">Quiénes somos</h1>
  <span class="page-desc">Ayudamos a los objetos únicos a encontrar nuevos dueños que los valoren.</span>

  <div class="mision">
    <h2>Nuestra misión</h2>
    <p>RialBids es un marketplace de subastas online que conecta compradores y vendedores de objetos únicos en Europa. Creemos que cada objeto tiene una historia y merece encontrar a alguien que lo valore.</p>
    <p>Nuestras subastas llegan a compradores de toda Europa, lo que significa que tus objetos pueden alcanzar su verdadero valor de mercado con pujas competitivas cada semana.</p>
  </div>

  <div class="stats">
    <div class="stat"><div class="stat-num">9%</div><div class="stat-label">Comisión + €3</div><div class="stat-sub">La más competitiva de Europa</div></div>
    <div class="stat"><div class="stat-num">100%</div><div class="stat-label">Pago seguro</div><div class="stat-sub">Custodia hasta confirmar entrega</div></div>
    <div class="stat"><div class="stat-num">7</div><div class="stat-label">Días de subasta</div><div class="stat-sub">Con anti-sniping activo</div></div>
  </div>

  <div class="steps">
    <div class="step"><div class="step-num">1</div><div><p class="step-h">El vendedor sube su lote</p><p class="step-p">Con fotos, descripción y precio inicial. Nuestro equipo lo revisa antes de publicarlo.</p></div></div>
    <div class="step"><div class="step-num">2</div><div><p class="step-h">Los compradores pujan</p><p class="step-p">Durante 7 días, compradores de toda Europa compiten por el lote. El anti-sniping garantiza subastas justas.</p></div></div>
    <div class="step"><div class="step-num">3</div><div><p class="step-h">Pago seguro en custodia</p><p class="step-p">El ganador paga y el dinero queda retenido hasta confirmar la entrega. El vendedor envía y todos quedan protegidos.</p></div></div>
  </div>

  <div class="cta-wrap">
    <h2 class="cta-h">Empezá hoy</h2>
    <p class="cta-p">Tanto si querés comprar objetos únicos como vender los tuyos, RialBids es tu plataforma.</p>
    <div class="cta-btns">
      <a href="/" class="cta-btn-blue">Ver subastas</a>
      <a href="/seller-request" class="cta-btn-ghost">Vender en RialBids</a>
    </div>
  </div>
</div>
@endsection
