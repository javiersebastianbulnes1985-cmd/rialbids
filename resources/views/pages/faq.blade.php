@extends('layouts.app')
@section('title','Preguntas frecuentes — RialBids')
@section('content')
<style>
.page-wrap{max-width:800px;margin:48px auto;padding:0 24px}
.page-tag{display:inline-block;background:#f3f4f6;color:#374151;font-size:11px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;padding:4px 12px;border-radius:20px;margin-bottom:14px}
.page-h1{font-size:28px;font-weight:700;color:#111;margin:0 0 8px}
.page-desc{font-size:14px;color:#9ca3af;display:block;margin-bottom:40px;padding-bottom:32px;border-bottom:1px solid #e5e7eb}
.faq-group-title{font-size:12px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:#374151;margin:32px 0 14px;display:flex;align-items:center;gap:10px}
.faq-group-title::after{content:'';flex:1;height:1px;background:#e5e7eb}
.faq-list{display:flex;flex-direction:column;gap:10px}
.faq-item{border:1px solid #e5e7eb;border-radius:10px;padding:18px 20px}
.faq-q{font-size:14px;font-weight:600;color:#111;margin:0 0 6px}
.faq-a{font-size:13px;color:#6b7280;margin:0;line-height:1.7}
.faq-contact{border:1px solid #e5e7eb;border-radius:10px;padding:20px;margin-top:32px}
.faq-contact h3{font-size:15px;font-weight:600;color:#111;margin:0 0 8px}
.faq-contact p{font-size:14px;color:#6b7280;margin:0}
.faq-contact a{color:#1a56db}
</style>
<div class="page-wrap">
  <div class="page-tag">Ayuda</div>
  <h1 class="page-h1">Preguntas frecuentes</h1>
  <span class="page-desc">Todo lo que necesitás saber sobre RialBids</span>
  <div class="faq-group-title">Para compradores</div>
  <div class="faq-list">
    <div class="faq-item"><p class="faq-q">¿Cómo funciona una subasta?</p><p class="faq-a">Cada lote tiene un precio inicial y un temporizador. Realizás tu puja y si nadie supera tu oferta al cierre, ganás el lote. Tenés 3 días para completar el pago.</p></div>
    <div class="faq-item"><p class="faq-q">¿Es seguro pagar en RialBids?</p><p class="faq-a">Sí. Los pagos son procesados por Stripe, líder mundial en pagos seguros. RialBids no almacena datos de tarjetas.</p></div>
    <div class="faq-item"><p class="faq-q">¿Cuánto cobra RialBids al comprador?</p><p class="faq-a">Nada. RialBids no cobra ningún cargo adicional al comprador. La comisión la paga el vendedor.</p></div>
    <div class="faq-item"><p class="faq-q">¿Cómo está protegido mi pago?</p><p class="faq-a">Tu pago queda retenido en custodia a través de Stripe hasta que confirmás la recepción del objeto. El vendedor no recibe el dinero hasta que vos confirmás que todo está bien.</p></div>
    <div class="faq-item"><p class="faq-q">¿Qué es la protección al comprador?</p><p class="faq-a">Si el objeto no llega o no coincide con la descripción, RialBids interviene para protegerte y gestionar el reembolso.</p></div>
    <div class="faq-item"><p class="faq-q">¿Quién paga el envío?</p><p class="faq-a">El envío corre por cuenta del comprador. El vendedor informa el costo de envío en la descripción del lote.</p></div>
    <div class="faq-item"><p class="faq-q">¿Qué pasa si el vendedor no envía el objeto?</p><p class="faq-a">Si el vendedor no marca el envío en 10 días, la venta se cancela automáticamente y recibís un reembolso completo. El vendedor puede ser suspendido de la plataforma.</p></div>
    <div class="faq-item"><p class="faq-q">¿Puedo cancelar una puja?</p><p class="faq-a">No. Todas las pujas en RialBids son vinculantes e irrevocables. Al realizar una puja estás comprometido a pagar si resultás ganador.</p></div>
    <div class="faq-item"><p class="faq-q">¿Cómo se garantiza la transparencia de las subastas?</p><p class="faq-a">Todas nuestras subastas siguen un proceso transparente y controlado. Nuestro sistema garantiza que todos los compradores tengan las mismas oportunidades durante todo el proceso.</p></div>
    <div class="faq-item"><p class="faq-q">¿Qué métodos de pago aceptan?</p><p class="faq-a">Aceptamos tarjetas de crédito y débito (Visa, Mastercard), Apple Pay y Google Pay, procesados de forma segura a través de Stripe.</p></div>
  </div>
  <div class="faq-group-title">Para vendedores</div>
  <div class="faq-list">
    <div class="faq-item"><p class="faq-q">¿Cómo puedo vender en RialBids?</p><p class="faq-a">Completá el formulario de solicitud de vendedor, conectá tu cuenta Stripe para recibir pagos y subí tus primeros lotes. Nuestro equipo revisa y aprueba cada lote antes de publicarlo.</p></div>
    <div class="faq-item"><p class="faq-q">¿Cuánto cobra RialBids al vendedor?</p><p class="faq-a">Comisiones de las más bajas del mercado europeo. Sin costo de publicación — solo pagás si vendés. Registrate como vendedor para ver todos los detalles.</p></div>
    <div class="faq-item"><p class="faq-q">¿Cuándo cobro?</p><p class="faq-a">Una vez que el comprador confirma la recepción del objeto, el pago se libera automáticamente a tu cuenta Stripe.</p></div>
    <div class="faq-item"><p class="faq-q">¿Quién gestiona el envío?</p><p class="faq-a">El vendedor es responsable del envío al comprador. Debés indicar el costo y método de envío en la descripción del lote.</p></div>
    <div class="faq-item"><p class="faq-q">¿Qué objetos puedo vender?</p><p class="faq-a">Joyería, arte, antigüedades, relojes, coleccionismo y más. Los objetos deben ser auténticos y descritos con precisión. RialBids se reserva el derecho de rechazar lotes que no cumplan los estándares de calidad.</p></div>
    <div class="faq-item"><p class="faq-q">¿Qué pasa si mi objeto no se vende?</p><p class="faq-a">Si la subasta finaliza sin pujas o sin alcanzar el precio de reserva, el lote no se vende y no se cobra ninguna comisión. Podés volver a publicarlo.</p></div>
  </div>
  <div class="faq-contact">
    <h3>¿No encontraste tu respuesta?</h3>
    <p>Escribinos a <a href="mailto:info@rialbids.com">info@rialbids.com</a>. Respondemos en menos de 24 horas en días hábiles.</p>
  </div>
</div>
@endsection
