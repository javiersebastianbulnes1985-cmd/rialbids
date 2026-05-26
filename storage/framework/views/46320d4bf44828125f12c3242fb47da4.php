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
  <p style="font-size:13px;color:#6b7280;margin-bottom:20px;">Bienvenido de vuelta a RialBids</p>

  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('status')): ?>
    <div style="background:#f0fdf4;border:1px solid #86efac;color:#166534;padding:10px;border-radius:8px;font-size:13px;margin-bottom:16px;">
      <?php echo e(session('status')); ?>

    </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

  <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:20px;">
    <a href="<?php echo e(route('auth.google')); ?>" style="display:flex;align-items:center;justify-content:center;gap:10px;padding:11px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;font-weight:500;color:#111827;text-decoration:none;background:#fff;">
      <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844c-.209 1.125-.843 2.078-1.796 2.716v2.259h2.908c1.702-1.567 2.684-3.875 2.684-6.615z" fill="#4285F4"/><path d="M9 18c2.43 0 4.467-.806 5.956-2.184l-2.908-2.259c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332A8.997 8.997 0 009 18z" fill="#34A853"/><path d="M3.964 10.706A5.41 5.41 0 013.682 9c0-.593.102-1.17.282-1.706V4.962H.957A8.996 8.996 0 000 9c0 1.452.348 2.827.957 4.038l3.007-2.332z" fill="#FBBC05"/><path d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0A8.997 8.997 0 00.957 4.962L3.964 6.294C4.672 4.169 6.656 3.58 9 3.58z" fill="#EA4335"/></svg>
      Continuar con Google
    </a>
    <a href="#" style="display:flex;align-items:center;justify-content:center;gap:10px;padding:11px;border-radius:8px;font-size:14px;font-weight:500;color:#fff;text-decoration:none;background:#1877F2;">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="white"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
      Continuar con Facebook
    </a>
    <a href="#" style="display:flex;align-items:center;justify-content:center;gap:10px;padding:11px;border-radius:8px;font-size:14px;font-weight:500;color:#fff;text-decoration:none;background:#000;">
      <svg width="16" height="18" viewBox="0 0 814 1000" fill="white"><path d="M788.1 340.9c-5.8 4.5-108.2 62.2-108.2 190.5 0 148.4 130.3 200.9 134.2 202.2-.6 3.2-20.7 71.9-68.7 141.9-42.8 61.6-87.5 123.1-155.5 123.1s-85.5-39.5-164-39.5c-76 0-103.7 40.8-165.9 40.8s-105.2-52-165.9-121.9C112 375.1 27.6 256.1 27.6 204.8c0-119.9 95.6-186.7 190.1-186.7 56.7 0 104.4 37.9 139.5 37.9 33.5 0 86.5-40.1 152.5-40.1 61.4 0 120.9 24.4 163.7 75.1zm-209.4-163c-22.6-26.9-42.2-68.7-42.2-110.4 0-5.8.6-11.6 1.3-17.4 42.2 1.3 93.3 28.2 124.7 60.5 23.9 25.7 43.5 68.7 43.5 110.4 0 6.4-.6 12.9-1.9 18.1-5.2.6-10.3 1.3-15.5 1.3-42.2 0-90.5-25.1-109.9-62.5z"/></svg>
      Continuar con Apple
    </a>
  </div>

  <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
    <div style="flex:1;height:1px;background:#e5e7eb;"></div>
    <span style="font-size:12px;color:#9ca3af;">o con email</span>
    <div style="flex:1;height:1px;background:#e5e7eb;"></div>
  </div>

  <form method="POST" action="<?php echo e(route('login')); ?>">
    <?php echo csrf_field(); ?>
    <div style="margin-bottom:16px;">
      <label style="font-size:13px;font-weight:500;color:#374151;display:block;margin-bottom:5px;">Email</label>
      <input style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;outline:none;box-sizing:border-box;" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus placeholder="tu@email.com">
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
      <input style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;outline:none;box-sizing:border-box;" type="password" name="password" required placeholder="Tu contraseña">
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
    <button type="submit" style="width:100%;padding:11px;background:#1a56db;color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;">Iniciar sesión</button>
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