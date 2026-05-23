<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
  <h2 style="font-size:20px;font-weight:700;color:#111827;margin-bottom:6px;">Iniciar sesión</h2>
  <p style="font-size:13px;color:#6b7280;margin-bottom:24px;">Bienvenido de vuelta a RialBids</p>

  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('status')): ?>
    <div style="background:#f0fdf4;border:1px solid #86efac;color:#166534;padding:10px;border-radius:8px;font-size:13px;margin-bottom:16px;">
      <?php echo e(session('status')); ?>

    </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

  <form method="POST" action="<?php echo e(route('login')); ?>">
    <?php echo csrf_field(); ?>

    <div style="margin-bottom:16px;">
      <label style="font-size:13px;font-weight:500;color:#374151;display:block;margin-bottom:5px;">Email</label>
      <input style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;outline:none;font-family:'Inter',sans-serif;" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus placeholder="tu@email.com">
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p style="color:#ef4444;font-size:12px;margin-top:4px;"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div style="margin-bottom:16px;">
      <div style="display:flex;justify-content:space-between;margin-bottom:5px;">
        <label style="font-size:13px;font-weight:500;color:#374151;">Contraseña</label>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Route::has('password.request')): ?>
          <a href="<?php echo e(route('password.request')); ?>" style="font-size:13px;color:#1a56db;">¿Olvidaste tu contraseña?</a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>
      <input style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;outline:none;font-family:'Inter',sans-serif;" type="password" name="password" required placeholder="Tu contraseña">
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p style="color:#ef4444;font-size:12px;margin-top:4px;"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div style="margin-bottom:20px;display:flex;align-items:center;gap:8px;">
      <input type="checkbox" name="remember" id="remember" style="width:16px;height:16px;accent-color:#1a56db;">
      <label for="remember" style="font-size:13px;color:#374151;">Recordarme</label>
    </div>

    <button type="submit" style="width:100%;padding:11px;background:#1a56db;color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;">Iniciar sesión</button>

    <p style="text-align:center;margin-top:16px;font-size:13px;color:#6b7280;">
      ¿No tenés cuenta? <a href="<?php echo e(route('register')); ?>" style="color:#1a56db;font-weight:500;">Registrarse</a>
    </p>
  </form>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH /home/u396549633/domains/rialbids.com/public_html/resources/views/auth/login.blade.php ENDPATH**/ ?>