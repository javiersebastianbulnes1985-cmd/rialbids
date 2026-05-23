<?php $__env->startSection('content'); ?>
<style>
@media(max-width:600px){
  .profile-table th.hide-mobile, .profile-table td.hide-mobile{display:none}
  .profile-table{font-size:12px}
}
</style>
<div style="max-width:900px;margin:32px auto;padding:0 16px">

  
  <div style="background:#1a56db;border-radius:14px;padding:24px;margin-bottom:24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px">
    <div style="display:flex;align-items:center;gap:16px">
      <div style="width:56px;height:56px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.5"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      </div>
      <div>
        <p style="font-size:18px;font-weight:700;color:#fff;margin:0"><?php echo e(auth()->user()->name); ?></p>
        <p style="font-size:13px;color:rgba(255,255,255,0.75);margin:3px 0 0"><?php echo e(auth()->user()->email); ?></p>
        <p style="font-size:12px;color:rgba(255,255,255,0.6);margin:2px 0 0">Miembro desde <?php echo e(auth()->user()->created_at->format('M Y')); ?></p>
      </div>
    </div>
    <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap">
      <div style="text-align:center">
        <p style="font-size:28px;font-weight:800;color:#fff;margin:0"><?php echo e($bids->count()); ?></p>
        <p style="font-size:12px;color:rgba(255,255,255,0.75);margin:0">Pujas realizadas</p>
      </div>
      <form method="POST" action="<?php echo e(route('logout')); ?>">
        <?php echo csrf_field(); ?>
        <button type="submit" style="background:rgba(255,255,255,0.15);color:#fff;border:1px solid rgba(255,255,255,0.3);border-radius:8px;padding:8px 16px;font-size:13px;font-weight:600;cursor:pointer;white-space:nowrap">
          → Cerrar sesión
        </button>
      </form>
    </div>
  </div>

  
  <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden">
    <div style="padding:16px 20px;border-bottom:1px solid #e5e7eb;display:flex;justify-content:space-between;align-items:center">
      <h2 style="font-size:15px;font-weight:700;color:#111;margin:0">Historial de pujas</h2>
      <span style="font-size:13px;color:#9ca3af"><?php echo e($bids->count()); ?> total</span>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bids->isEmpty()): ?>
      <div style="padding:48px;text-align:center;color:#9ca3af">
        <p style="font-size:15px">Todavía no hiciste ninguna puja.</p>
        <a href="<?php echo e(route('home')); ?>" style="color:#1a56db;font-size:13px;margin-top:8px;display:inline-block">Ver subastas →</a>
      </div>
    <?php else: ?>
      <div style="overflow-x:auto">
        <table class="profile-table" style="width:100%;border-collapse:collapse;min-width:320px">
          <thead style="background:#f9fafb">
            <tr>
              <th style="padding:10px 16px;text-align:left;font-size:11px;color:#6b7280;font-weight:600">Lote</th>
              <th style="padding:10px 16px;text-align:left;font-size:11px;color:#6b7280;font-weight:600">Tu puja</th>
              <th class="hide-mobile" style="padding:10px 16px;text-align:left;font-size:11px;color:#6b7280;font-weight:600">Precio actual</th>
              <th style="padding:10px 16px;text-align:left;font-size:11px;color:#6b7280;font-weight:600">Estado</th>
              <th class="hide-mobile" style="padding:10px 16px;text-align:left;font-size:11px;color:#6b7280;font-weight:600">Fecha</th>
              <th style="padding:10px 16px"></th>
            </tr>
          </thead>
          <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $bids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr style="border-top:1px solid #f3f4f6">
              <td style="padding:12px 16px">
                <a href="<?php echo e(route('auctions.show', $bid->auction_id)); ?>" style="text-decoration:none">
                  <p style="font-size:13px;font-weight:600;color:#111;margin:0"><?php echo e(Str::limit($bid->auction->title ?? '—', 30)); ?></p>
                  <p style="font-size:11px;color:#9ca3af;margin:2px 0 0">#<?php echo e(str_pad($bid->auction_id,4,'0',STR_PAD_LEFT)); ?></p>
                </a>
              </td>
              <td style="padding:12px 16px">
                <p style="font-size:14px;font-weight:700;color:#1a56db;margin:0">€<?php echo e(number_format($bid->amount,0,',','.')); ?></p>
              </td>
              <td class="hide-mobile" style="padding:12px 16px">
                <p style="font-size:13px;color:#374151;margin:0">€<?php echo e(number_format($bid->auction->current_price ?? 0,0,',','.')); ?></p>
              </td>
              <td style="padding:12px 16px">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bid->auction && $bid->auction->status === 'shipped' && $bid->auction->winner_id === auth()->id()): ?>
                  <span style="background:#eff6ff;color:#2563eb;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;white-space:nowrap">📦 Enviado</span>
                <?php elseif($bid->auction && $bid->auction->status === 'delivered' && $bid->auction->winner_id === auth()->id()): ?>
                  <span style="background:#f0fdf4;color:#16a34a;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600">✓ Entregado</span>
                <?php elseif($bid->auction && $bid->auction->status === 'completed'): ?>
                  <span style="background:#f0fdf4;color:#15803d;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600">✓ Completado</span>
                <?php elseif($bid->auction && $bid->auction->current_price == $bid->amount): ?>
                  <span style="background:#d1fae5;color:#065f46;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600">Ganando</span>
                <?php else: ?>
                  <span style="background:#fee2e2;color:#991b1b;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600">Superado</span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </td>
              <td class="hide-mobile" style="padding:12px 16px;font-size:11px;color:#9ca3af">
                <?php echo e($bid->created_at->format('d/m/Y H:i')); ?>

              </td>
              <td style="padding:12px 16px">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bid->auction && $bid->auction->status === 'shipped' && $bid->auction->winner_id === auth()->id()): ?>
                  <form method="POST" action="<?php echo e(route('auctions.confirm', $bid->auction_id)); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" style="background:#16a34a;color:#fff;border:none;border-radius:6px;padding:5px 10px;font-size:11px;cursor:pointer;font-weight:600;white-space:nowrap">✓ Recibido</button>
                  </form>
                <?php elseif($bid->auction): ?>
                  <a href="<?php echo e(route('auctions.show', $bid->auction_id)); ?>" style="font-size:12px;color:#1a56db;text-decoration:none;font-weight:600;white-space:nowrap">Ver →</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u396549633/domains/rialbids.com/public_html/resources/views/profile/index.blade.php ENDPATH**/ ?>