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
    <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">Un comprador abrio una disputa sobre tu lote <strong>"<?php echo e($titulo); ?>"</strong>.</p>
    <p style="font-size:14px;color:#374151;line-height:1.6;margin:0 0 6px"><strong>Motivo:</strong> <?php echo e($dispute->reason); ?></p>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dispute->description): ?>
    <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0 0 20px;padding:12px;background:#f9fafb;border-radius:8px">"<?php echo e($dispute->description); ?>"</p>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">Antes de tomar una decision, queremos escuchar tu version. Tenes <strong>3 dias</strong> para responder con tu descargo. Si no respondes, resolveremos con la informacion disponible.</p>
    <table cellpadding="0" cellspacing="0" style="margin:8px 0 24px"><tr><td style="background:#1a3a6b;border-radius:8px"><a href="<?php echo e(url('/vendor')); ?>" style="display:inline-block;padding:12px 28px;color:#fff;font-size:15px;font-weight:600;text-decoration:none">Responder la disputa</a></td></tr></table>
    <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0 0 24px">Mientras tanto, el pago de esta operacion queda retenido hasta resolver la situacion.</p>
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
<?php /**PATH /home/u396549633/domains/rialbids.com/public_html/resources/views/emails/disputa_vendedor.blade.php ENDPATH**/ ?>