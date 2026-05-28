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
<td style="padding:10px"><a href="https://dashboard.stripe.com/payments" target="_blank" style="font-size:11px;background:#1d4ed8;color:#fff;padding:4px 8px;border-radius:6px;text-decoration:none">Ver Stripe</a></td></tr>
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
<td style="padding:10px"><?php echo e($p->comprador); ?></td>
<td style="padding:10px"><?php echo e($p->vendedor); ?></td>
<td style="padding:10px;text-align:right;font-weight:700">EUR <?php echo e(number_format($p->final_price, 2)); ?></td>
<td style="padding:10px"><?php echo e(strtoupper($p->status)); ?></td>
<td style="padding:10px;font-size:12px"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($p->tracking_number): ?><?php echo e($p->tracking_carrier); ?> - <?php echo e($p->tracking_number); ?><?php else: ?><span style="color:#ef4444">Sin tracking</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></td>
<td style="padding:10px;font-size:12px"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($p->payment_released_at): ?><span style="color:#16a34a">Liberado</span><?php elseif($p->payment_release_scheduled_at): ?><?php echo e(CarbonCarbon::parse($p->payment_release_scheduled_at)->diffForHumans()); ?><?php else: ?>-<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></td>
<td style="padding:10px"><a href="https://dashboard.stripe.com/payments" target="_blank" style="font-size:11px;background:#1d4ed8;color:#fff;padding:4px 8px;border-radius:6px;text-decoration:none">Ver Stripe</a></td></tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</tbody></table>
<?php else: ?>
<p style="font-size:13px;color:#6b7280;margin:0">No hay pagos en transito.</p>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u396549633/domains/rialbids.com/public_html/resources/views/admin/pagos.blade.php ENDPATH**/ ?>