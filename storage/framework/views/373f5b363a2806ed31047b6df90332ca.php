<?php $__env->startSection('title','Vender en RialBids'); ?>
<?php $__env->startSection('content'); ?>
<div style="max-width:800px;margin:48px auto;padding:0 24px;">

  <h1 style="font-size:28px;font-weight:700;color:#111;margin-bottom:8px;">Vendé en RialBids</h1>
  <p style="font-size:15px;color:#6b7280;margin-bottom:40px;">Subastá tus objetos al mejor precio. Comisión del 9% + €3 solo si vendés.</p>

  <div style="display:flex;flex-direction:column;gap:16px;margin-bottom:48px;">

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:20px;display:flex;gap:16px;align-items:flex-start;">
      <div style="width:36px;height:36px;background:#eff6ff;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-weight:700;color:#1a56db;">1</div>
      <div>
        <h3 style="font-size:15px;font-weight:600;color:#111;margin-bottom:4px;">Registrate como vendedor</h3>
        <p style="font-size:13px;color:#6b7280;line-height:1.6;">Completá el formulario de abajo. Tu cuenta se activa automáticamente.</p>
      </div>
    </div>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:20px;display:flex;gap:16px;align-items:flex-start;">
      <div style="width:36px;height:36px;background:#eff6ff;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-weight:700;color:#1a56db;">2</div>
      <div>
        <h3 style="font-size:15px;font-weight:600;color:#111;margin-bottom:4px;">Subí tu lote</h3>
        <p style="font-size:13px;color:#6b7280;line-height:1.6;">Completá título, descripción, fotos y precio base desde tu panel de vendedor.</p>
      </div>
    </div>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:20px;display:flex;gap:16px;align-items:flex-start;">
      <div style="width:36px;height:36px;background:#eff6ff;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-weight:700;color:#1a56db;">3</div>
      <div>
        <h3 style="font-size:15px;font-weight:600;color:#111;margin-bottom:4px;">Aprobación en menos de 24hs</h3>
        <p style="font-size:13px;color:#6b7280;line-height:1.6;">Revisamos cada lote antes de publicarlo para garantizar calidad y confianza.</p>
      </div>
    </div>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:20px;display:flex;gap:16px;align-items:flex-start;">
      <div style="width:36px;height:36px;background:#eff6ff;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-weight:700;color:#1a56db;">4</div>
      <div>
        <h3 style="font-size:15px;font-weight:600;color:#111;margin-bottom:4px;">La subasta comienza</h3>
        <p style="font-size:13px;color:#6b7280;line-height:1.6;">Tu lote aparece en el catálogo y los compradores pujan. Seguí el progreso desde tu panel.</p>
      </div>
    </div>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:20px;display:flex;gap:16px;align-items:flex-start;">
      <div style="width:36px;height:36px;background:#eff6ff;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-weight:700;color:#1a56db;">5</div>
      <div>
        <h3 style="font-size:15px;font-weight:600;color:#111;margin-bottom:4px;">Cobrás tu venta</h3>
        <p style="font-size:13px;color:#6b7280;line-height:1.6;">RialBids cobra 9% + €3 por venta exitosa. El resto es tuyo, transferido directamente a tu cuenta.</p>
      </div>
    </div>

  </div>

  <div style="background:#fff;border:2px solid #1a56db;border-radius:12px;padding:32px;">
    <h2 style="font-size:20px;font-weight:700;color:#111;margin-bottom:4px;">Activá tu cuenta de vendedor</h2>
    <p style="font-size:14px;color:#6b7280;margin-bottom:24px;">Gratis. Sin compromiso. Tu cuenta se activa al instante.</p>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
      <div style="background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p><?php echo e($error); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <form action="/seller-request" method="POST">
      <?php echo csrf_field(); ?>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
        <div>
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Nombre completo *</label>
          <input type="text" name="name" value="<?php echo e(old('name')); ?>" required
                 style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
        </div>
        <div>
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Email *</label>
          <input type="email" name="email" value="<?php echo e(old('email')); ?>" required
                 style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
        </div>
      </div>

      <div style="margin-bottom:16px;">
        <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">País *</label>
        <select name="country" required
                style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
          <option value="">Seleccioná tu país</option>
          <option value="España">España</option>
          <option value="Francia">Francia</option>
          <option value="Italia">Italia</option>
          <option value="Alemania">Alemania</option>
          <option value="Portugal">Portugal</option>
          <option value="Países Bajos">Países Bajos</option>
          <option value="Bélgica">Bélgica</option>
          <option value="Suecia">Suecia</option>
          <option value="Polonia">Polonia</option>
          <option value="Austria">Austria</option>
          <option value="Suiza">Suiza</option>
          <option value="Dinamarca">Dinamarca</option>
          <option value="Noruega">Noruega</option>
          <option value="Finlandia">Finlandia</option>
          <option value="Grecia">Grecia</option>
          <option value="Otro">Otro</option>
        </select>
      </div>

      <div style="margin-bottom:24px;">
        <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">¿Qué querés vender? *</label>
        <textarea name="what_sells" rows="3" required
                  style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;"><?php echo e(old('what_sells')); ?></textarea>
        <p style="font-size:12px;color:#9ca3af;margin-top:4px;">Describí brevemente el tipo de objetos que querés subastar.</p>
      </div>

      <button type="submit" style="width:100%;padding:14px;background:#1a56db;color:#fff;border:none;border-radius:8px;font-size:15px;font-weight:600;cursor:pointer;">
        Activar mi cuenta de vendedor →
      </button>
    </form>
  </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u396549633/domains/rialbids.com/public_html/resources/views/seller-request/create.blade.php ENDPATH**/ ?>