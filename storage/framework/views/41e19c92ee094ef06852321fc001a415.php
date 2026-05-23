<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Lote #<?php echo e($auction->id); ?> — Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Inter',sans-serif;background:#f9fafb;color:#111827}
  </style>
</head>
<body>
<div style="max-width:860px;margin:40px auto;padding:0 20px;">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
    <h1 style="font-size:22px;font-weight:700;color:#111;">Editar lote #<?php echo e($auction->id); ?></h1>
    <a href="<?php echo e(route('admin.index')); ?>" style="color:#6b7280;font-size:13px;text-decoration:none;">← Volver al panel</a>
  </div>

  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
  <div style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:20px;">
    <?php echo e(session('success')); ?>

  </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
  <div style="background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p style="margin:2px 0;"><?php echo e($error); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

  <form action="<?php echo e(route('admin.auctions.update', $auction->id)); ?>" method="POST" enctype="multipart/form-data"
        style="background:#fff;padding:32px;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.1);">
    <?php echo csrf_field(); ?>

    <div style="margin-bottom:20px;">
      <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Título *</label>
      <input type="text" name="title" value="<?php echo e($auction->title); ?>" required
             style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;">
    </div>

    <div style="margin-bottom:20px;">
      <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Descripción</label>
      <textarea name="description" rows="4"
                style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;"><?php echo e($auction->description); ?></textarea>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:20px;">
      <div>
        <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Precio base (€) *</label>
        <input type="number" name="base_price" value="<?php echo e($auction->base_price); ?>" min="0" step="0.01" required
               style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;">
      </div>
      <div>
        <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Incremento mínimo (€)</label>
        <input type="number" name="min_increment" value="<?php echo e($auction->min_increment ?? 10); ?>" min="1"
               style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;">
      </div>
      <div>
        <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Precio de reserva (€)</label>
        <input type="number" name="reserve_price" value="<?php echo e($auction->reserve_price); ?>" min="0" step="0.01"
               style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;">
      </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
      <div>
        <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Fecha de cierre * (hora UTC)</label>
        <input type="datetime-local" name="end_time" value="<?php echo e(\Carbon\Carbon::parse($auction->end_time)->format('Y-m-d\TH:i')); ?>" required
               style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;">
      </div>
      <div>
        <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Estado</label>
        <select name="status" style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;">
          <option value="active" <?php echo e($auction->status==='active'?'selected':''); ?>>Activo</option>
          <option value="pending" <?php echo e($auction->status==='pending'?'selected':''); ?>>Pendiente</option>
          <option value="finished" <?php echo e($auction->status==='finished'?'selected':''); ?>>Finalizado</option>
          <option value="shipped" <?php echo e($auction->status==='shipped'?'selected':''); ?>>Enviado</option>
          <option value="paid" <?php echo e($auction->status==='paid'?'selected':''); ?>>Pagado</option>
          <option value="cancelled" <?php echo e($auction->status==='cancelled'?'selected':''); ?>>Cancelado</option>
        </select>
      </div>
    </div>

    <div style="margin-bottom:20px;">
      <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Categoría</label>
      <select name="lot_category" style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['general'=>'General','arte'=>'Arte','joyas'=>'Joyas','relojes'=>'Relojes','coleccionismo'=>'Coleccionismo','electronica'=>'Electrónica','muebles'=>'Antigüedades']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($val); ?>" <?php echo e($auction->lot_category===$val?'selected':''); ?>><?php echo e($label); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </select>
    </div>

    <div style="margin-bottom:28px;">
      <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:10px;">Fotos</label>
      <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['image_'=>['field'=>'image_path','label'=>'Principal'],'image_2'=>['field'=>'image_path_2','label'=>'Foto 2'],'image_3'=>['field'=>'image_path_3','label'=>'Foto 3']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $input=>$info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div>
          <label style="font-size:12px;font-weight:500;color:#6b7280;display:block;margin-bottom:6px;"><?php echo e($info['label']); ?></label>
          <div style="width:100%;height:140px;border:2px dashed #e5e7eb;border-radius:8px;overflow:hidden;display:flex;align-items:center;justify-content:center;background:#f9fafb;margin-bottom:8px;">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($auction->{$info['field']})): ?>
              <img src="<?php echo e(asset('storage/'.$auction->{$info['field']})); ?>" style="width:100%;height:100%;object-fit:cover;">
            <?php else: ?>
              <span style="font-size:12px;color:#9ca3af;">Sin foto</span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </div>
          <input type="file" name="<?php echo e($input); ?>" accept="image/*" style="width:100%;font-size:13px;">
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>
      <div style="margin-top:14px;">
        <label style="font-size:13px;font-weight:500;color:#374151;display:block;margin-bottom:5px;">Video YouTube <span style="color:#9ca3af;">opcional</span></label>
        <input type="url" name="video_url" value="<?php echo e($auction->video_url); ?>"
               style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;"
               placeholder="https://www.youtube.com/watch?v=...">
      </div>
    </div>

    <div style="display:flex;gap:12px;">
      <button type="submit"
              style="flex:1;padding:12px;background:#2563eb;color:#fff;border:none;border-radius:8px;font-size:15px;font-weight:600;cursor:pointer;">

        <div style="margin-bottom:20px">
          <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Número de tracking</label>
          <input type="text" name="tracking_number" value="<?php echo e($auction->tracking_number); ?>" placeholder="Ej: ES123456789CN" style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;">
          <div style="font-size:11px;color:#9ca3af;margin-top:4px">Número de seguimiento del envío (DHL, Correos, MRW, etc.)</div>
        </div>
        Guardar cambios
      </button>
      <a href="<?php echo e(route('admin.index')); ?>"
         style="flex:1;padding:12px;background:#f9fafb;color:#374151;border:1.5px solid #e5e7eb;border-radius:8px;font-size:15px;font-weight:600;text-align:center;text-decoration:none;">
        Cancelar
      </a>
    </div>
  </form>

  
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($auction->status !== 'cancelled'): ?>
  <div style="margin-top:32px;border:2px solid #fca5a5;border-radius:12px;padding:24px;background:#fff5f5;">
    <h3 style="font-size:14px;font-weight:700;color:#991b1b;margin:0 0 8px">⚠️ Zona de peligro</h3>
    <p style="font-size:13px;color:#7f1d1d;margin:0 0 16px">Cancelar este lote notificará por email al vendor y a todos los pujadores. Esta acción queda registrada y <strong>no se puede deshacer</strong>.</p>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($auction->total_bids ?? 0) > 0): ?>
    <div style="background:#fef3c7;border:1px solid #fbbf24;border-radius:8px;padding:10px 14px;margin-bottom:16px;font-size:12px;color:#92400e;">
      ⚠️ Este lote tiene <strong><?php echo e($auction->total_bids); ?> puja(s)</strong>. Al cancelarlo se notificará a todos los pujadores que no serán cobrados.
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <button onclick="if(confirm('⚠️ ADVERTENCIA\n\n¿Estás seguro que querés cancelar este lote?\n\nEsta acción notificará al vendor y a todos los pujadores por email y NO se puede deshacer.')) { document.getElementById('cancel-zone').style.display='block';this.style.display='none' }"
            style="background:#dc2626;color:#fff;border:none;border-radius:8px;padding:10px 20px;font-size:13px;font-weight:600;cursor:pointer;">
      Cancelar este lote
    </button>
    <div id="cancel-zone" style="display:none;margin-top:16px;">
      <form method="POST" action="<?php echo e(route('admin.destroy',$auction->id)); ?>">
        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
        <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Motivo de cancelación <span style="color:#dc2626;">*</span></label>
        <textarea name="motivo" required placeholder="Ej: Objeto fraudulento, viola las políticas de RialBids, producto no permitido..." style="width:100%;padding:10px;border:1.5px solid #fca5a5;border-radius:8px;font-size:13px;height:90px;resize:none;margin-bottom:12px;box-sizing:border-box;"></textarea>
        <div style="display:flex;gap:10px;">
          <button type="submit" style="background:#dc2626;color:#fff;border:none;border-radius:8px;padding:10px 24px;font-size:13px;font-weight:700;cursor:pointer;">
            Confirmar cancelación
          </button>
          <button type="button" onclick="document.getElementById('cancel-zone').style.display='none';document.querySelector('.cancel-trigger').style.display='block'"
                  style="background:#f3f4f6;color:#374151;border:none;border-radius:8px;padding:10px 24px;font-size:13px;font-weight:600;cursor:pointer;">
            Volver
          </button>
        </div>
      </form>
    </div>
  </div>
  <?php else: ?>
  <div style="margin-top:32px;border:2px solid #e5e7eb;border-radius:12px;padding:20px;background:#f9fafb;">
    <p style="font-size:13px;color:#6b7280;margin:0;">🚫 Este lote está cancelado. Motivo: <em><?php echo e($auction->rejection_reason ?? 'No especificado'); ?></em></p>
  </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>
</body>
</html>
<?php /**PATH /home/u396549633/domains/rialbids.com/public_html/resources/views/admin/edit.blade.php ENDPATH**/ ?>