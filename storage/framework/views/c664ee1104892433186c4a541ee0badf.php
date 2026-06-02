<?php $__env->startSection('content'); ?>
<div style="max-width:800px;margin:40px auto;padding:0 20px">
  <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px">
    <a href="<?php echo e(route('vendor.index')); ?>" style="color:#6b7280;text-decoration:none;font-size:13px">← Volver al panel</a>
  </div>
  <h1 style="font-size:20px;font-weight:700;color:#111827;margin:0 0 6px">Editar lote #<?php echo e(str_pad($auction->id,4,'0',STR_PAD_LEFT)); ?></h1>
  <p style="font-size:13px;color:#f59e0b;margin:0 0 24px">⏳ En revisión — podés editar hasta que el admin lo apruebe.</p>

  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
  <div style="background:#fef2f2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:13px">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div>• <?php echo e($e); ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

  <form method="POST" action="<?php echo e(route('vendor.update',$auction->id)); ?>" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:24px;margin-bottom:16px">
      <h2 style="font-size:14px;font-weight:700;color:#111;margin:0 0 16px">Información del objeto</h2>
      <div style="margin-bottom:16px">
        <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px">Título *</label>
        <input type="text" name="title" value="<?php echo e(old('title',$auction->title)); ?>" required
          style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box">
      </div>
      <div style="margin-bottom:16px">
        <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px">Descripción * <span style="font-weight:400;color:#9ca3af">(mín. 80 caracteres)</span></label>
        <textarea name="description" required rows="5"
          style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;resize:vertical"><?php echo e(old('description',$auction->description)); ?></textarea>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px">
        <div>
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px">Precio base (€) *</label>
          <input type="number" name="base_price" value="<?php echo e(old('base_price',$auction->base_price)); ?>" min="20" required
            style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box">
        </div>
        <div>
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px">Precio reserva (€)</label>
          <input type="number" name="reserve_price" value="<?php echo e(old('reserve_price',$auction->reserve_price)); ?>" min="0"
            style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box">
        </div>
        <div>
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px">Condición *</label>
          <select name="condition" required style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box">
            <option value="excelente" <?php echo e($auction->condition==='excelente'?'selected':''); ?>>Excelente</option>
            <option value="muy_bueno" <?php echo e($auction->condition==='muy_bueno'?'selected':''); ?>>Muy bueno</option>
            <option value="bueno" <?php echo e($auction->condition==='bueno'?'selected':''); ?>>Bueno</option>
            <option value="regular" <?php echo e($auction->condition==='regular'?'selected':''); ?>>Regular</option>
          </select>
        </div>
        <div>
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px">Duración</label>
          <select name="duracion" style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box">
            <option value="7">7 días</option>
            <option value="14">14 días</option>
            <option value="21">21 días</option>
            <option value="30" selected>30 días</option>
          </select>
        </div>
      </div>
    </div>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:24px;margin-bottom:16px">
      <h2 style="font-size:14px;font-weight:700;color:#111;margin:0 0 16px">Fotos <span style="font-weight:400;font-size:12px;color:#9ca3af">Las fotos actuales se mantienen si no subís nuevas</span></h2>
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px">
        <?php $fotoCampos = [['name'=>'image','field'=>'image_path','label'=>'Foto 1 — Principal'],['name'=>'image_2','field'=>'image_path_2','label'=>'Foto 2'],['name'=>'image_3','field'=>'image_path_3','label'=>'Foto 3'],['name'=>'image_4','field'=>'image_path_4','label'=>'Foto 4'],['name'=>'image_5','field'=>'image_path_5','label'=>'Foto 5'],['name'=>'image_6','field'=>'image_path_6','label'=>'Foto 6']]; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $fotoCampos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div>
          <label style="display:block;font-size:12px;font-weight:600;color:#374151;margin-bottom:6px"><?php echo e($f['label']); ?></label>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($auction->{$f['field']})): ?>
            <img src="<?php echo e(str_starts_with($auction->{$f['field']},'http') ? $auction->{$f['field']} : asset('storage/'.$auction->{$f['field']})); ?>"
              style="width:100%;height:100px;object-fit:cover;border-radius:8px;border:1px solid #e5e7eb;margin-bottom:6px">
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          <input type="file" name="<?php echo e($f['name']); ?>" accept="image/*"
            style="width:100%;font-size:12px;padding:6px;border:1px solid #d1d5db;border-radius:6px;box-sizing:border-box">
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>
    </div>

    <div style="margin-bottom:16px">
      <a href="<?php echo e(url('/auctions/' . $auction->slug)); ?>" target="_blank"
        style="display:block;width:100%;padding:12px;background:#f0f9ff;color:#0369a1;border:1px solid #bae6fd;border-radius:8px;font-size:14px;font-weight:600;text-align:center;text-decoration:none;box-sizing:border-box;">
        👁 Ver preview del lote →
      </a>
    </div>
    <div style="display:flex;gap:12px">
      <button type="submit" style="flex:1;padding:14px;background:#111827;color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:700;cursor:pointer">
        Guardar cambios
      </button>
      <a href="<?php echo e(route('vendor.index')); ?>" style="flex:1;padding:14px;background:#f3f4f6;color:#374151;border-radius:8px;font-size:14px;font-weight:600;text-align:center;text-decoration:none">
        Cancelar
      </a>
    </div>
  </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u396549633/domains/rialbids.com/public_html/resources/views/vendor/edit.blade.php ENDPATH**/ ?>