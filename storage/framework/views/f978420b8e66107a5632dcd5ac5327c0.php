<?php $__env->startSection('content'); ?>
<div style="max-width:1100px;margin:0 auto;padding:24px 16px">
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px">
<div><h1 style="font-size:20px;font-weight:700;margin:0">Panel de Pagos y Disputas</h1>
<p style="font-size:12px;color:#6b7280;margin:4px 0 0">Disputas activas y pagos en transito</p></div>
<a href="<?php echo e(route('admin.index')); ?>" style="font-size:13px;color:#6b7280;text-decoration:none">Volver al panel</a>
</div>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($disputas) > 0): ?>
<div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:10px;padding:20px;margin-bottom:28px">
<h2 style="font-size:15px;font-weight:700;color:#991b1b;margin:0 0 16px">DISPUTAS ACTIVAS (<?php echo e(count($disputas)); ?>)</h2>
<table style="width:100%;border-collapse:collapse;font-size:13px">
<thead><tr style="background:#fee2e2"><th style="padding:10px;text-align:left">Subasta</th><th style="padding:10px;text-align:left">Comprador</th><th style="padding:10px;text-align:left">Vendedor</th><th style="padding:10px;text-align:right">Monto</th><th style="padding:10px;text-align:left">Estado</th><th style="padding:10px;text-align:left">Fecha</th><th style="padding:10px;text-align:left">Stripe</th></tr></thead><tbody>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $disputas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr style="border-bottom:1px solid #fecaca">
<td style="padding:10px"><a href="<?php echo e(route('auctions.show', $d->id)); ?>" style="color:#dc2626;font-weight:600">#<?php echo e($d->id); ?> <?php echo e($d->title); ?></a></td>
<td style="padding:10px"><?php echo e($d->comprador); ?><br><small><?php echo e($d->comprador_email); ?></small></td>
<td style="padding:10px"><?php echo e($d->vendedor); ?></td>
<td style="padding:10px;text-align:right;font-weight:700">EUR <?php echo e(number_format($d->final_price, 2)); ?></td>
<td style="padding:10px"><?php echo e(strtoupper($d->dispute_status ?? 'ABIERTA')); ?></td>
<td style="padding:10px;font-size:12px"><?php echo e($d->disputed_at ? CarbonCarbon::parse($d->disputed_at)->format('d/m/Y H:i') : '-'); ?></td>
<td style="padding:10px"><a href="https://dashboard.stripe.com/disputes/<?php echo e($d->dispute_id); ?>" target="_blank" style="color:#dc2626">Ver en Stripe</a></td>
<td style="padding:10px"><form method="POST" action="<?php echo e(route('admin.pagos.liberar', $p->id)); ?>" style="display:inline"><?php echo csrf_field(); ?><button type="submit" onclick="return confirm('¿Liberar pago al vendedor?')" style="font-size:11px;background:#16a34a;color:#fff;padding:4px 8px;border-radius:6px;border:none;cursor:pointer;margin-right:4px">Liberar</button></form><form method="POST" action="<?php echo e(route('admin.pagos.reembolsar', $p->id)); ?>" style="display:inline"><?php echo csrf_field(); ?><button type="submit" onclick="return confirm('¿Reembolsar al comprador?')" style="font-size:11px;background:#dc2626;color:#fff;padding:4px 8px;border-radius:6px;border:none;cursor:pointer">Reembolsar</button></form></td></tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</tbody></table></div>
<?php else: ?>
<div style="background:#f0fdf4;border:1px solid #86efac;border-radius:10px;padding:16px;margin-bottom:28px">
<p style="margin:0;color:#166534">Sin disputas activas</p></div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:20px;margin-bottom:28px">
<h2 style="font-size:15px;font-weight:700;color:#1f2937;margin:0 0 16px">PAGOS EN TRANSITO (<?php echo e(count($pendientes)); ?>)</h2>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($pendientes) > 0): ?>
<table style="width:100%;border-collapse:collapse;font-size:13px">
<thead><tr style="background:#f9fafb"><th style="padding:10px;text-align:left">Subasta</th><th style="padding:10px;text-align:left">Comprador</th><th style="padding:10px;text-align:left">Vendedor</th><th style="padding:10px;text-align:right">Monto</th><th style="padding:10px;text-align:left">Estado</th><th style="padding:10px;text-align:left">Tracking</th><th style="padding:10px;text-align:left">Libera</th><th style="padding:10px;text-align:left">Acciones</th></tr></thead><tbody>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $pendientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr style="border-bottom:1px solid #f3f4f6">
<td style="padding:10px"><a href="<?php echo e(route('auctions.show', $p->id)); ?>" style="color:#1d4ed8;font-weight:600">#<?php echo e($p->id); ?> <?php echo e($p->title); ?></a></td>
<td style="padding:10px">
  <strong><?php echo e($p->comprador); ?></strong><br>
  <small style="color:#6b7280"><?php echo e($p->comprador_email ?? ''); ?></small>
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($p->comprador_address)): ?>
  <br><small style="color:#374151;margin-top:2px;display:block">
    <?php echo e($p->comprador_address); ?>, <?php echo e($p->comprador_city); ?> <?php echo e($p->comprador_postal); ?><br>
    <?php echo e($p->comprador_country); ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($p->comprador_phone)): ?> &middot; <?php echo e($p->comprador_phone); ?><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </small>
  <?php else: ?>
  <br><small style="color:#ef4444">Sin dirección registrada</small>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</td>
<td style="padding:10px"><?php echo e($p->vendedor); ?></td>
<td style="padding:10px;text-align:right;font-weight:700">EUR <?php echo e(number_format($p->final_price, 2)); ?></td>
<td style="padding:10px"><?php echo e(strtoupper($p->status)); ?></td>
<td style="padding:10px;font-size:12px"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($p->tracking_number): ?><?php echo e($p->tracking_carrier); ?> - <?php echo e($p->tracking_number); ?><?php else: ?><span style="color:#ef4444">Sin tracking</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></td>
<td style="padding:10px;font-size:12px"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($p->payment_released_at): ?><span style="color:#16a34a">Liberado</span><?php elseif($p->payment_release_scheduled_at): ?><?php echo e(CarbonCarbon::parse($p->payment_release_scheduled_at)->diffForHumans()); ?><?php else: ?>-<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></td>
<td style="padding:10px"><form method="POST" action="<?php echo e(route('admin.pagos.liberar', $p->id)); ?>" style="display:inline"><?php echo csrf_field(); ?><button type="submit" onclick="return confirm('¿Liberar pago al vendedor?')" style="font-size:11px;background:#16a34a;color:#fff;padding:4px 8px;border-radius:6px;border:none;cursor:pointer;margin-right:4px">Liberar</button></form><form method="POST" action="<?php echo e(route('admin.pagos.reembolsar', $p->id)); ?>" style="display:inline"><?php echo csrf_field(); ?><button type="submit" onclick="return confirm('¿Reembolsar al comprador?')" style="font-size:11px;background:#dc2626;color:#fff;padding:4px 8px;border-radius:6px;border:none;cursor:pointer">Reembolsar</button></form></td></tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</tbody></table>
<?php else: ?>
<p style="font-size:13px;color:#6b7280;margin:0">No hay pagos en transito.</p>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
</div>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($disputasComprador) && count($disputasComprador) > 0): ?>
<div style="background:#fff;border:1px solid #fca5a5;border-radius:12px;padding:20px;margin-bottom:24px">
<h2 style="font-size:15px;font-weight:700;color:#991b1b;margin:0 0 16px">DISPUTAS DE COMPRADORES (<?php echo e(count($disputasComprador)); ?>)</h2>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $disputasComprador; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div style="border:1px solid #e5e7eb;border-radius:8px;padding:14px;margin-bottom:12px">
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
<span style="font-size:14px;font-weight:700;color:#111827"><?php echo e($dc->lote_title ?? ('Lote #'.$dc->auction_id)); ?></span>
<span style="font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;background:#fef9ec;color:#8a6820"><?php echo e(strtoupper(str_replace('_',' ',$dc->status))); ?></span>
</div>
<p style="font-size:12px;color:#6b7280;margin:0 0 6px">Comprador: <strong><?php echo e($dc->comprador); ?></strong> (<?php echo e($dc->comprador_email); ?>) &middot; Vendedor: <strong><?php echo e($dc->vendedor); ?></strong> &middot; EUR <?php echo e(number_format($dc->final_price ?? 0, 2)); ?></p>
<p style="font-size:12px;color:#374151;margin:0 0 6px"><strong>Motivo:</strong> <?php echo e($dc->reason); ?></p>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dc->description): ?><p style="font-size:12px;color:#6b7280;margin:0 0 8px;padding:8px 10px;background:#f9fafb;border-radius:6px">Comprador dice: "<?php echo e($dc->description); ?>"</p><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dc->seller_response): ?>
<div style="margin:0 0 8px;padding:10px 12px;background:#eff6ff;border-left:3px solid #1a3a6b;border-radius:6px">
<p style="font-size:11px;font-weight:700;color:#1a3a6b;margin:0 0 4px">Version del vendedor:</p>
<p style="font-size:12px;color:#374151;margin:0">"<?php echo e($dc->seller_response); ?>"</p>
</div>
<?php else: ?>
<p style="font-size:11px;color:#b45309;margin:0 0 8px;font-style:italic">El vendedor todavia no respondio.</p>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<p style="font-size:13px;color:#374151;background:#f9fafb;padding:10px;border-radius:6px;margin:0 0 8px"><?php echo e($dc->description); ?></p>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dc->photo_path): ?><a href="<?php echo e(asset('storage/'.$dc->photo_path)); ?>" target="_blank" style="font-size:12px;color:#1a3a6b">Ver foto adjunta</a> &middot; <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<a href="<?php echo e(route('auctions.show', $dc->auction_id)); ?>" target="_blank" style="font-size:12px;color:#1a3a6b">Ver lote</a>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!in_array($dc->status, ['resuelta_comprador','resuelta_vendedor','cerrada'])): ?>
<div style="margin-top:12px;padding-top:12px;border-top:1px solid #f3f4f6;display:flex;gap:8px;flex-wrap:wrap">
<form method="POST" action="<?php echo e(route('admin.disputes.resolver', $dc->id)); ?>" style="display:inline"><?php echo csrf_field(); ?><input type="hidden" name="accion" value="comprador"><button type="submit" onclick="return confirm('ATENCION - ACCION CON DINERO REAL\n\nVas a REEMBOLSAR al comprador <?php echo e($dc->comprador); ?>.\nLote: <?php echo e($dc->lote_title); ?>\nMonto: EUR <?php echo e(number_format($dc->final_price ?? 0, 2)); ?>\n\nEsta accion mueve plata en Stripe y no se puede deshacer.\n\nConfirmas?')" style="font-size:11px;background:#dc2626;color:#fff;padding:5px 12px;border-radius:6px;border:none;cursor:pointer;font-weight:600">Dar razon al comprador (reembolsar)</button></form>
<form method="POST" action="<?php echo e(route('admin.disputes.resolver', $dc->id)); ?>" style="display:inline"><?php echo csrf_field(); ?><input type="hidden" name="accion" value="vendedor"><button type="submit" onclick="return confirm('ATENCION - ACCION CON DINERO REAL\n\nVas a LIBERAR el pago al vendedor <?php echo e($dc->vendedor); ?>.\nLote: <?php echo e($dc->lote_title); ?>\nMonto: EUR <?php echo e(number_format($dc->final_price ?? 0, 2)); ?>\n\nEsta accion transfiere plata a la cuenta del vendedor y no se puede deshacer.\n\nConfirmas?')" style="font-size:11px;background:#16a34a;color:#fff;padding:5px 12px;border-radius:6px;border:none;cursor:pointer;font-weight:600">Dar razon al vendedor (liberar)</button></form>
<form method="POST" action="<?php echo e(route('admin.disputes.resolver', $dc->id)); ?>" style="display:inline"><?php echo csrf_field(); ?><input type="hidden" name="accion" value="revision"><button type="submit" style="font-size:11px;background:#fff;color:#374151;padding:5px 12px;border-radius:6px;border:1px solid #d1d5db;cursor:pointer;font-weight:600">Marcar en revision</button></form>
</div>
<?php else: ?>
<div style="margin-top:10px;font-size:11px;color:#16a34a;font-weight:600">Resuelta <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dc->resolved_at): ?>&middot; <?php echo e(\Carbon\Carbon::parse($dc->resolved_at)->format('d/m/Y')); ?><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u396549633/domains/rialbids.com/public_html/resources/views/admin/pagos.blade.php ENDPATH**/ ?>