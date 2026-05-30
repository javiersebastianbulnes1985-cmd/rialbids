<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="margin:0;padding:0;background:#f3f4f6;font-family:Arial,sans-serif">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f3f4f6;padding:40px 20px">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:12px;overflow:hidden;max-width:600px">

  
  <tr><td style="padding:32px 32px 16px;text-align:center;border-bottom:1px solid #e5e7eb"><a href="<?php echo e(url('/')); ?>" style="text-decoration:none"><span style="color:#111827;font-size:28px;font-weight:800;font-family:Georgia,serif;letter-spacing:-1px">RialBids</span></a>
  </td></tr>

  
  <tr><td style="padding:32px">
    <h2 style="font-size:22px;font-weight:700;color:#111;margin:0 0 8px">Hola <?php echo e($user->name); ?>!</h2>
    <p style="font-size:15px;color:#374151;margin:0 0 24px">Tu cuenta fue creada exitosamente. Ya podes empezar a pujar en subastas unicas.</p>

    <div style="background:#f9fafb;border-radius:8px;padding:20px;margin-bottom:24px">
      <p style="font-size:14px;font-weight:700;color:#111;margin:0 0 12px">Como funciona en 3 pasos:</p>
      <p style="font-size:14px;color:#374151;margin:0 0 8px"><strong>1.</strong> Explora las subastas activas y encontra algo unico</p>
      <p style="font-size:14px;color:#374151;margin:0 0 8px"><strong>2.</strong> Hace tu puja — rapido, seguro, sin complicaciones</p>
      <p style="font-size:14px;color:#374151;margin:0"><strong>3.</strong> Si ganas, pagas con tarjeta y recibis tu objeto en casa</p>
    </div>

    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px">
      <tr>
        <td align="center">
          <a href="<?php echo e(url('/')); ?>" style="background:#1a56db;color:#fff;padding:12px 28px;border-radius:8px;font-size:15px;font-weight:700;text-decoration:none;display:inline-block">Ver subastas en vivo</a>
        </td>
      </tr>
    </table>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subastas->count() > 0): ?>
    <p style="font-size:15px;font-weight:700;color:#111;margin:0 0 16px">Subastas cerrando pronto:</p>
    <table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $subastas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <td style="width:50%;padding:0 8px 0 <?php echo e($loop->first ? '0' : '8px'); ?>;vertical-align:top">
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($s->image_path): ?>
          <img src="<?php echo e(url('storage/'.$s->image_path)); ?>" style="width:100%;height:150px;object-fit:cover;border-radius:8px;display:block">
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          <p style="font-size:13px;font-weight:700;color:#111;margin:8px 0 4px"><?php echo e($s->title); ?></p>
          <p style="font-size:13px;color:#1a56db;margin:0 0 8px">€<?php echo e(number_format($s->current_price,0,',','.')); ?></p>
          <a href="<?php echo e(url('/auctions/'.$s->id)); ?>" style="background:#1a56db;color:#fff;padding:6px 14px;border-radius:6px;font-size:12px;font-weight:600;text-decoration:none">Pujar ahora</a>
        </td>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </tr>
    </table>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

  </td></tr>

  
  <tr><td style="background:#f9fafb;padding:20px 32px;border-top:1px solid #e5e7eb">
    <p style="font-size:12px;color:#9ca3af;margin:0;text-align:center">Cualquier consulta escribinos a <a href="mailto:info@rialbids.com" style="color:#1a56db">info@rialbids.com</a></p>
    <p style="font-size:12px;color:#9ca3af;margin:4px 0 0;text-align:center">© 2026 RialBids. Todos los derechos reservados.</p>
  </td></tr>

</table>
</td></tr>
</table>
</body>
</html>
<?php /**PATH /home/u396549633/domains/rialbids.com/public_html/resources/views/emails/bienvenida_comprador.blade.php ENDPATH**/ ?>