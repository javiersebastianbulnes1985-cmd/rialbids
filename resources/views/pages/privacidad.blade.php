@extends('layouts.app')
@section('title','Política de privacidad — RialBids')
@section('content')
<style>
.page-wrap{max-width:800px;margin:48px auto;padding:0 24px}
.page-tag{display:inline-block;background:#f3f4f6;color:#374151;font-size:11px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;padding:4px 12px;border-radius:20px;margin-bottom:14px}
.page-h1{font-size:28px;font-weight:700;color:#111;margin:0 0 8px}
.page-date{font-size:13px;color:#9ca3af;display:block;margin-bottom:40px;padding-bottom:32px;border-bottom:1px solid #e5e7eb}
.page-sections{display:flex;flex-direction:column}
.page-section{display:flex;gap:20px;padding:24px 0;border-bottom:1px solid #f3f4f6}
.page-section:last-child{border-bottom:none}
.sec-num{flex-shrink:0;width:32px;height:32px;background:#f3f4f6;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;color:#374151}
.sec-h2{font-size:15px;font-weight:600;color:#111;margin:0 0 8px}
.sec-p{font-size:14px;color:#6b7280;line-height:1.75;margin:0 0 8px}
.sec-p:last-child{margin:0}
.sec-ul{font-size:14px;color:#6b7280;line-height:1.9;padding-left:20px;margin:8px 0 0}
.sec-link{color:#1a56db;text-decoration:none}
</style>
<div class="page-wrap">
  <div class="page-tag">Legal</div>
  <h1 class="page-h1">Política de privacidad</h1>
  <span class="page-date"></span>
  <div class="page-sections">
    <div class="page-section"><div class="sec-num">1</div><div><h2 class="sec-h2">Responsable del tratamiento</h2><p class="sec-p">El responsable del tratamiento de tus datos personales es RialBids, con domicilio a efectos de comunicaciones en info@rialbids.com. Si tenés alguna consulta sobre el tratamiento de tus datos, podés contactarnos en esa dirección.</p></div></div>
    <div class="page-section"><div class="sec-num">2</div><div><h2 class="sec-h2">Datos que recopilamos</h2><p class="sec-p">Recopilamos los siguientes datos personales:</p><ul class="sec-ul"><li>Datos de registro: nombre, email y contraseña (cifrada)</li><li>Datos de uso: pujas realizadas, lotes visitados, subastas ganadas</li><li>Datos de pago: procesados exclusivamente por Stripe — RialBids no almacena datos de tarjetas</li><li>Datos de envío: dirección de entrega cuando realizás una compra</li><li>Datos técnicos: dirección IP, tipo de navegador, páginas visitadas</li></ul></div></div>
    <div class="page-section"><div class="sec-num">3</div><div><h2 class="sec-h2">Finalidad del tratamiento</h2><p class="sec-p">Usamos tus datos para:</p><ul class="sec-ul"><li>Gestionar tu cuenta y acceso a la plataforma</li><li>Procesar pujas, compras y pagos</li><li>Gestionar envíos y comunicaciones relacionadas con tus pedidos</li><li>Prevenir fraudes y garantizar la seguridad de la plataforma</li><li>Enviarte comunicaciones de servicio (confirmaciones, alertas de puja)</li><li>Mejorar nuestros servicios mediante análisis de uso</li></ul></div></div>
    <div class="page-section"><div class="sec-num">4</div><div><h2 class="sec-h2">Base legal del tratamiento</h2><p class="sec-p">El tratamiento de tus datos se basa en: (a) la ejecución del contrato de uso de la plataforma; (b) el cumplimiento de obligaciones legales; (c) el interés legítimo de RialBids en prevenir fraudes y mejorar el servicio; (d) tu consentimiento para comunicaciones de marketing, que podés retirar en cualquier momento.</p></div></div>
    <div class="page-section"><div class="sec-num">5</div><div><h2 class="sec-h2">Conservación de datos</h2><p class="sec-p">Conservamos tus datos mientras mantengas una cuenta activa en RialBids. Si eliminás tu cuenta, borraremos tus datos personales en un plazo máximo de 30 días, salvo que debamos conservarlos por obligaciones legales (por ejemplo, datos de facturación durante 5 años por obligaciones fiscales).</p></div></div>
    <div class="page-section"><div class="sec-num">6</div><div><h2 class="sec-h2">Compartición de datos</h2><p class="sec-p">Compartimos datos únicamente con:</p><ul class="sec-ul"><li>Stripe: para el procesamiento seguro de pagos</li><li>Vendedores: dirección de envío cuando ganás una subasta</li><li>Autoridades competentes: cuando lo exija la ley</li></ul><p class="sec-p" style="margin-top:8px">No vendemos ni cedemos tus datos a terceros con fines comerciales.</p></div></div>
    <div class="page-section"><div class="sec-num">7</div><div><h2 class="sec-h2">Transferencias internacionales</h2><p class="sec-p">Stripe puede procesar datos fuera del Espacio Económico Europeo, bajo las garantías adecuadas establecidas por la normativa europea (cláusulas contractuales tipo). RialBids no realiza transferencias internacionales de datos propias.</p></div></div>
    <div class="page-section"><div class="sec-num">8</div><div><h2 class="sec-h2">Tus derechos (RGPD)</h2><p class="sec-p">De acuerdo con el Reglamento General de Protección de Datos (RGPD), tenés derecho a:</p><ul class="sec-ul"><li><strong>Acceso:</strong> conocer qué datos tenemos sobre vos</li><li><strong>Rectificación:</strong> corregir datos inexactos</li><li><strong>Supresión:</strong> solicitar la eliminación de tus datos</li><li><strong>Portabilidad:</strong> recibir tus datos en formato estructurado</li><li><strong>Oposición:</strong> oponerte al tratamiento para fines de marketing</li><li><strong>Limitación:</strong> solicitar la limitación del tratamiento en ciertos casos</li></ul><p class="sec-p" style="margin-top:8px">Para ejercer cualquiera de estos derechos, contactanos en info@rialbids.com. También podés presentar una reclamación ante la Agencia Española de Protección de Datos (AEPD) en <a href="https://www.aepd.es" class="sec-link">www.aepd.es</a>.</p></div></div>
    <div class="page-section"><div class="sec-num">9</div><div><h2 class="sec-h2">Cookies</h2><p class="sec-p">RialBids utiliza cookies técnicas necesarias para el funcionamiento de la plataforma (sesión, autenticación) y cookies de análisis para mejorar el servicio. Podés gestionar las cookies desde la configuración de tu navegador. El uso continuado de la plataforma implica la aceptación de las cookies técnicas necesarias.</p></div></div>
    <div class="page-section"><div class="sec-num">10</div><div><h2 class="sec-h2">Seguridad</h2><p class="sec-p">Aplicamos medidas técnicas y organizativas para proteger tus datos: cifrado HTTPS, contraseñas hasheadas, acceso restringido a datos sensibles y monitoreo de seguridad. Los pagos son gestionados exclusivamente por Stripe, que cumple con los estándares PCI DSS.</p></div></div>
    <div class="page-section"><div class="sec-num">11</div><div><h2 class="sec-h2">Contacto</h2><p class="sec-p">Para cualquier consulta sobre esta política de privacidad o el tratamiento de tus datos, contactanos en <a href="mailto:info@rialbids.com" class="sec-link">info@rialbids.com</a></p></div></div>
  </div>
</div>
@endsection
