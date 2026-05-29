@extends('layouts.app')
@section('title','Protección al comprador — RialBids')
@section('content')
<style>
.page-wrap{max-width:800px;margin:48px auto;padding:0 24px}
.page-tag{display:inline-block;background:#f3f4f6;color:#374151;font-size:11px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;padding:4px 12px;border-radius:20px;margin-bottom:14px}
.page-h1{font-size:28px;font-weight:700;color:#111;margin:0 0 8px}
.page-desc{font-size:13px;color:#9ca3af;display:block;margin-bottom:32px;padding-bottom:28px;border-bottom:1px solid #e5e7eb}
.alert-green{background:#f0fdf4;border:1px solid #86efac;border-radius:10px;padding:20px;margin-bottom:28px}
.alert-green h2{font-size:15px;font-weight:700;color:#166534;margin:0 0 8px}
.alert-green p{font-size:14px;color:#166534;line-height:1.7;margin:0}
.alert-plain{border:1px solid #e5e7eb;border-radius:10px;padding:20px;margin-top:28px}
.alert-plain h2{font-size:15px;font-weight:700;color:#111;margin:0 0 8px}
.alert-plain p{font-size:14px;color:#6b7280;margin:0}
.alert-plain a{color:#1a56db;font-weight:600}
.sec-title{font-size:15px;font-weight:600;color:#111;margin:0 0 16px}
.steps{display:flex;flex-direction:column;gap:16px;margin-bottom:28px}
.step{display:flex;gap:16px;align-items:flex-start}
.step-num{width:28px;height:28px;border-radius:50%;background:#1a56db;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;flex-shrink:0}
.step-num.green{background:#16a34a}
.step-h{font-size:14px;font-weight:600;color:#111;margin:0 0 4px}
.step-p{font-size:13px;color:#6b7280;margin:0;line-height:1.6}
.cards{display:flex;flex-direction:column;gap:12px;margin-bottom:28px}
.card{border:1px solid #e5e7eb;border-radius:8px;padding:16px}
.card-h{font-size:14px;font-weight:600;color:#111;margin:0 0 6px}
.card-p{font-size:13px;color:#6b7280;margin:0;line-height:1.6}
.sec-divider{border:none;border-top:1px solid #f3f4f6;margin:28px 0}
table{width:100%;border-collapse:collapse;margin-bottom:0}
thead tr{background:#f9fafb}
th{text-align:left;padding:10px 16px;font-size:12px;color:#6b7280;font-weight:600;border:1px solid #e5e7eb}
td{padding:10px 16px;font-size:13px;border:1px solid #e5e7eb;color:#374151}
tr:nth-child(even){background:#f9fafb}
</style>
<div class="page-wrap">
  <div class="page-tag">Comprador</div>
  <h1 class="page-h1">Protección al comprador</h1>
  <span class="page-desc">Tu compra está protegida en cada paso</span>
  <div class="alert-green">
    <h2>✅ Tu pago está seguro</h2>
    <p>Cuando ganás una subasta, tu pago queda retenido en custodia a través de Stripe. El dinero no se libera al vendedor hasta que confirmás que recibiste el objeto en buen estado.</p>
  </div>
  <h2 class="sec-title">¿Cómo funciona la protección?</h2>
  <div class="steps">
    <div class="step"><div class="step-num">1</div><div><p class="step-h">Ganás la subasta y pagás</p><p class="step-p">Tu pago queda retenido de forma segura. El vendedor no recibe el dinero todavía.</p></div></div>
    <div class="step"><div class="step-num">2</div><div><p class="step-h">El vendedor envía el objeto</p><p class="step-p">El vendedor tiene un máximo de 10 días para enviar con número de seguimiento. Si no envía, la venta se cancela y te reembolsamos.</p></div></div>
    <div class="step"><div class="step-num">3</div><div><p class="step-h">Recibís y revisás el objeto</p><p class="step-p">Tenés 3 días para revisar el objeto. Si no corresponde a la descripción, podés abrir una disputa.</p></div></div>
    <div class="step"><div class="step-num green">4</div><div><p class="step-h">Confirmás la recepción</p><p class="step-p">Una vez que confirmás, el pago se libera al vendedor. Si no confirmás en 7 días, se libera automáticamente.</p></div></div>
  </div>
  <hr class="sec-divider">
  <h2 class="sec-title">¿Qué pasa si hay un problema?</h2>
  <div class="cards">
    <div class="card"><p class="card-h">El objeto no llega</p><p class="card-p">Si el vendedor no envía en 10 días, cancelamos la venta y te reembolsamos el 100% del pago.</p></div>
    <div class="card"><p class="card-h">El objeto no es como se describía</p><p class="card-p">Tenés 3 días desde la recepción para reportarlo. Investigamos el caso y podemos ofrecerte reembolso total o parcial.</p></div>
    <div class="card"><p class="card-h">El objeto llegó dañado</p><p class="card-p">Reportalo dentro de los 3 días con fotos del daño. Mediamos con el vendedor para encontrar una solución.</p></div>
  </div>
  <hr class="sec-divider">
  <h2 class="sec-title">Plazos importantes</h2>
  <table>
    <thead><tr><th>Situación</th><th>Plazo</th><th>Qué ocurre</th></tr></thead>
    <tbody>
      <tr><td>Pago del comprador</td><td>3 días desde el cierre</td><td>Si no paga, se suspende la cuenta</td></tr>
      <tr><td>Envío del vendedor</td><td>10 días desde el pago</td><td>Si no envía, reembolso automático</td></tr>
      <tr><td>Reporte de problemas</td><td>3 días desde recepción</td><td>Podés abrir disputa</td></tr>
      <tr><td>Liberación automática</td><td>7 días desde enviado</td><td>Pago liberado al vendedor</td></tr>
    </tbody>
  </table>
  <div class="alert-plain">
    <h2>¿Necesitás ayuda?</h2>
    <p>Si tenés un problema con tu compra, contactanos en <a href="mailto:info@rialbids.com">info@rialbids.com</a>. Respondemos en menos de 24 horas.</p>
  </div>
</div>
@endsection
