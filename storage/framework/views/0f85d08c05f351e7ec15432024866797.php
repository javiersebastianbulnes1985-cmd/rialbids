<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>
<body style="margin:0;padding:0;background:#f5f3ef;font-family:Arial,sans-serif">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f3ef;padding:40px 20px">
<tr><td align="center">
<table width="560" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:12px;overflow:hidden;max-width:560px;box-shadow:0 2px 8px rgba(0,0,0,0.06)">
  <tr><td style="background:#1a3a6b;padding:24px 32px;text-align:center">
    <span style="color:#fff;font-size:20px;font-weight:700;letter-spacing:0.5px">RialBids</span>
  </td></tr>
  <tr><td style="padding:32px">
    <p style="font-size:16px;color:#111827;margin:0 0 16px;font-weight:600">Hola <?php echo e($user->name); ?>,</p>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($destinatario === 'comprador' && $favor === 'comprador'): ?>
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">Revisamos tu disputa del lote <strong>"<?php echo e($titulo); ?>"</strong> y la resolvimos <strong style="color:#16a34a">a tu favor</strong>.</p>
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">El reembolso fue procesado. Veras el dinero acreditado en tu metodo de pago en los proximos dias habiles, segun tu banco.</p>
    <?php elseif($destinatario === 'comprador' && $favor === 'vendedor'): ?>
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">Revisamos con atencion tu disputa del lote <strong>"<?php echo e($titulo); ?>"</strong>.</p>
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">Tras evaluar la informacion de ambas partes, la disputa se resolvio a favor del vendedor. Si contas con informacion adicional, podes responder a este correo y la revisaremos.</p>
    <?php elseif($destinatario === 'vendedor' && $favor === 'vendedor'): ?>
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">La disputa del lote <strong>"<?php echo e($titulo); ?>"</strong> se resolvio <strong style="color:#16a34a">a tu favor</strong>.</p>
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">El pago fue liberado a tu cuenta. Lo veras reflejado segun los tiempos de tu cuenta de cobro.</p>
    <?php else: ?>
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">La disputa del lote <strong>"<?php echo e($titulo); ?>"</strong> se resolvio a favor del comprador.</p>
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">El pago no se liberara para esta operacion. Si tenes dudas sobre la decision, podes responder a este correo.</p>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0 0 24px">Gracias por usar RialBids y por tu compromiso con una comunidad de compraventa segura y transparente.</p>
    <p style="font-size:15px;color:#111827;margin:0">Equipo RialBids</p>
  </td></tr>
  <tr><td style="padding:16px 32px;border-top:1px solid #eee;text-align:center">
    <a href="<?php echo e(url('/')); ?>" style="color:#c9a84c;font-size:13px;text-decoration:none">rialbids.com</a>
  </td></tr>
</table>
</td></tr>
</table>
</body>
</html>
<?php /**PATH /home/u396549633/domains/rialbids.com/public_html/resources/views/emails/resolucion_disputa.blade.php ENDPATH**/ ?>