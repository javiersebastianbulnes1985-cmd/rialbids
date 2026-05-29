@extends('layouts.app')
@section('title','Garantía RialBids')
@section('content')
<style>
.page-wrap{max-width:800px;margin:48px auto;padding:0 24px}
.page-tag{display:inline-block;background:#f3f4f6;color:#374151;font-size:11px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;padding:4px 12px;border-radius:20px;margin-bottom:14px}
.page-h1{font-size:32px;font-weight:700;color:#111;margin:0 0 12px}
.page-desc{font-size:15px;color:#6b7280;line-height:1.7;margin:0 0 32px;padding-bottom:28px;border-bottom:1px solid #e5e7eb;display:block}
.garantias{display:flex;flex-direction:column;gap:12px;margin-bottom:28px}
.garantia-item{display:flex;gap:16px;align-items:flex-start;padding:18px 20px;border:1px solid #e5e7eb;border-radius:10px}
.garantia-check{width:26px;height:26px;border-radius:50%;background:#f3f4f6;border:1px solid #e5e7eb;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#374151;font-size:13px;font-weight:700}
.garantia-h{font-size:14px;font-weight:600;color:#111;margin:0 0 4px}
.garantia-p{font-size:13px;color:#6b7280;margin:0;line-height:1.6}
.plazos-wrap{background:#f0fdf4;border:1px solid #86efac;border-radius:12px;padding:24px;margin-bottom:20px}
.plazos-title{font-size:15px;font-weight:700;color:#166534;margin:0 0 16px;text-align:center}
.plazos-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:12px}
.plazo-card{background:#fff;border-radius:8px;padding:16px;text-align:center}
.plazo-num{font-size:20px;font-weight:700;color:#166534}
.plazo-desc{font-size:11px;color:#6b7280;margin-top:4px}
.cta-wrap{background:#111827;border-radius:12px;padding:28px;text-align:center}
.cta-h{font-size:17px;font-weight:700;color:#fff;margin:0 0 8px}
.cta-p{font-size:14px;color:rgba(255,255,255,0.7);margin:0 0 16px}
.cta-btn{background:#1a56db;color:#fff;padding:10px 24px;border-radius:6px;font-size:14px;font-weight:600;text-decoration:none;display:inline-block}
</style>
<div class="page-wrap">
  <div class="page-tag">Confianza</div>
  <h1 class="page-h1">Garantía RialBids</h1>
  <span class="page-desc">RialBids es un lugar seguro para comprar y vender online.</span>
  <div class="garantias">
    <div class="garantia-item"><div class="garantia-check">✓</div><div><p class="garantia-h">Pago 100% seguro</p><p class="garantia-p">Tu pago queda protegido hasta que recibas el objeto. Un proceso seguro y transparente para compradores y vendedores.</p></div></div>
    <div class="garantia-item"><div class="garantia-check">✓</div><div><p class="garantia-h">Todos los lotes son revisados</p><p class="garantia-p">Nuestro equipo revisa cada lote antes de publicarlo para garantizar que la descripción sea precisa y las fotos sean reales.</p></div></div>
    <div class="garantia-item"><div class="garantia-check">✓</div><div><p class="garantia-h">Reembolso si el vendedor no envía</p><p class="garantia-p">Si el vendedor no envía en 10 días, la venta se cancela automáticamente y recibís un reembolso completo.</p></div></div>
    <div class="garantia-item"><div class="garantia-check">✓</div><div><p class="garantia-h">Protección contra fraudes</p><p class="garantia-p">Monitoreamos constantemente la plataforma para detectar comportamientos fraudulentos y proteger a compradores y vendedores.</p></div></div>
    <div class="garantia-item"><div class="garantia-check">✓</div><div><p class="garantia-h">Tecnología SSL y pagos con Stripe</p><p class="garantia-p">Toda la plataforma usa cifrado SSL. Los pagos son procesados por Stripe, el procesador de pagos más seguro del mundo.</p></div></div>
    <div class="garantia-item"><div class="garantia-check">✓</div><div><p class="garantia-h">Subastas transparentes</p><p class="garantia-p">Todas nuestras subastas siguen reglas claras y transparentes para garantizar una experiencia justa para todos los participantes.</p></div></div>
  </div>
  <div class="plazos-wrap">
    <p class="plazos-title">Plazos de protección</p>
    <div class="plazos-grid">
      <div class="plazo-card"><div class="plazo-num">3 días</div><div class="plazo-desc">Para pagar después de ganar</div></div>
      <div class="plazo-card"><div class="plazo-num">10 días</div><div class="plazo-desc">Para enviar el objeto</div></div>
      <div class="plazo-card"><div class="plazo-num">3 días</div><div class="plazo-desc">Para reportar problemas</div></div>
      <div class="plazo-card"><div class="plazo-num">7 días</div><div class="plazo-desc">Liberación automática del pago</div></div>
    </div>
  </div>
  <div class="cta-wrap">
    <h2 class="cta-h">¿Tenés alguna pregunta?</h2>
    <p class="cta-p">Nuestro equipo responde en menos de 24 horas.</p>
    <a href="mailto:info@rialbids.com" class="cta-btn">Contactar soporte</a>
  </div>
</div>
@endsection
