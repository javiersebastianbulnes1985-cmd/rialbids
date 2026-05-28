<?php $__env->startSection('title','Recuperar contrasena - RialBids'); ?>
<?php $__env->startSection('content'); ?>
<div style="max-width:420px;margin:60px auto;padding:0 24px;">
<div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:32px;">
<div style="text-align:center;margin-bottom:24px;">
<a href="/" style="font-size:20px;font-weight:700;color:#111827;text-decoration:none;">RialBids</a>
<h1 style="font-size:18px;font-weight:600;color:#111;margin:12px 0 8px;">Recuperar contrasena</h1>
<p style="font-size:13px;color:#6b7280;margin:0;">Ingresa tu email y te mandamos un link para crear una nueva contrasena.</p>
</div>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('status')): ?>
<div style="background:#f0fdf4;border:1px solid #86efac;color:#166534;padding:12px;border-radius:8px;font-size:13px;margin-bottom:16px;"><?php echo e(session('status')); ?></div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
<div style="background:#fef2f2;border:1px solid #fca5a5;color:#991b1b;padding:12px;border-radius:8px;font-size:13px;margin-bottom:16px;"><?php echo e($errors->first()); ?></div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<form method="POST" action="<?php echo e(route('password.email')); ?>">
<?php echo csrf_field(); ?>
<div style="margin-bottom:16px;">
<label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Email</label>
<input type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;outline:none;box-sizing:border-box;">
</div>
<button type="submit" style="width:100%;padding:12px;background:#111827;color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;">Enviar link de recuperacion</button>
</form>
<p style="text-align:center;font-size:13px;color:#6b7280;margin-top:16px;"><a href="<?php echo e(route('login')); ?>" style="color:#1a56db;">Volver al login</a></p>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u396549633/domains/rialbids.com/public_html/resources/views/auth/forgot-password.blade.php ENDPATH**/ ?>