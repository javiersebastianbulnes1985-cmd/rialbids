<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title><?php echo $__env->yieldContent('title', 'RialBids — Subastas Online'); ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Inter',sans-serif;background:#f9fafb;color:#111827}
    .nav{background:#fff;border-bottom:1px solid #e5e7eb;position:sticky;top:0;z-index:50}
    .nav-inner{max-width:1280px;margin:0 auto;padding:0 20px;height:60px;display:flex;align-items:center;gap:16px}
    .nav-logo{display:flex;align-items:center;gap:8px;text-decoration:none;flex-shrink:0}
    .nav-logo-box{width:34px;height:34px;background:#1a56db;border-radius:6px;display:flex;align-items:center;justify-content:center}
    .nav-logo-box span{color:#fff;font-weight:800;font-size:15px}
    .nav-logo-name{font-weight:700;font-size:17px;color:#1a56db}
    .nav-divider{width:1px;height:24px;background:#e5e7eb;flex-shrink:0}
    .nav-cats{display:flex;gap:2px;flex:1}
    .nav-cat{padding:6px 12px;border-radius:6px;text-decoration:none;font-size:13px;font-weight:500;color:#374151;transition:background .15s,color .15s}
    .nav-cat:hover{background:#eff6ff;color:#1a56db}
    .nav-search{flex:1;max-width:280px;position:relative}
    .nav-search svg{position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#9ca3af;pointer-events:none}
    .nav-search input{width:100%;padding:8px 14px 8px 34px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:13px;outline:none;background:#f9fafb}
    .nav-search input:focus{border-color:#1a56db;background:#fff}
    .nav-actions{display:flex;align-items:center;gap:8px;flex-shrink:0}
    .btn-ghost{padding:7px 14px;border-radius:7px;font-size:13px;font-weight:500;color:#374151;text-decoration:none;border:1.5px solid #e5e7eb;background:#fff}
    .btn-ghost:hover{border-color:#1a56db;color:#1a56db}
    .btn-blue{padding:8px 18px;border-radius:7px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;background:#1a56db;border:none;cursor:pointer}
    .btn-blue:hover{background:#1e429f}
    .footer{background:#111827;color:#fff;margin-top:64px}
    .footer-top{max-width:1280px;margin:0 auto;padding:48px 24px 40px;display:grid;grid-template-columns:1.6fr 1fr 1fr 1fr;gap:40px}
    .footer-brand-logo{display:flex;align-items:center;gap:8px;margin-bottom:14px}
    .footer-brand-box{width:30px;height:30px;background:#1a56db;border-radius:5px;display:flex;align-items:center;justify-content:center}
    .footer-brand-box span{color:#fff;font-weight:800;font-size:13px}
    .footer-brand-name{font-weight:700;font-size:15px;color:#fff}
    .footer-brand-desc{font-size:13px;color:#6b7280;line-height:1.65}
    .footer-col-title{font-size:11px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:#4b5563;margin-bottom:14px}
    .footer-link{display:block;font-size:13px;color:#6b7280;text-decoration:none;margin-bottom:9px}
    .footer-link:hover{color:#e5e7eb}
    .footer-bottom{border-top:1px solid #1f2937;padding:20px 24px;max-width:1280px;margin:0 auto;display:flex;justify-content:space-between;align-items:center}
    .footer-copy{font-size:12px;color:#4b5563}
    .footer-admin{font-size:12px;color:#374151;text-decoration:none}
    .footer-admin:hover{color:#1a56db}
    @media(max-width:900px){.nav-cats,.nav-divider{display:none}.nav-search{max-width:none}.footer-top{grid-template-columns:1fr 1fr;gap:28px}}
    @media(max-width:600px){.footer-top{grid-template-columns:1fr}.footer-bottom{flex-direction:column;gap:8px;text-align:center}}
  </style>
  <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
<nav class="nav">
  <div class="nav-inner">
    <a href="<?php echo e(route('home')); ?>" class="nav-logo">
      <div class="nav-logo-box"><span>R</span></div>
      <span class="nav-logo-name">RialBids</span>
    </a>
    <div class="nav-divider"></div>
    <div class="nav-cats">
      <a href="<?php echo e(route('home')); ?>" class="nav-cat">Todos</a>
      <a href="<?php echo e(route('home', ['categoria'=>'joyas'])); ?>" class="nav-cat">Joyería</a>
      <a href="<?php echo e(route('home', ['categoria'=>'arte'])); ?>" class="nav-cat">Arte</a>
      <a href="<?php echo e(route('home', ['categoria'=>'relojes'])); ?>" class="nav-cat">Relojes</a>
      <a href="<?php echo e(route('home', ['categoria'=>'muebles'])); ?>" class="nav-cat">Antigüedades</a>
      <a href="<?php echo e(route('home', ['categoria'=>'coleccionismo'])); ?>" class="nav-cat">Coleccionismo</a>
    </div>
    <div class="nav-search">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      <input type="text" placeholder="Buscar subastas..." onkeydown="if(event.key==='Enter'&&this.value.trim()){window.location='/?q='+encodeURIComponent(this.value)}">
    </div>
    <div class="nav-actions">
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
        <div style="position:relative;" x-data="{ open: false }">
          <button @click="open = !open"
                  style="width:36px;height:36px;border-radius:50%;background:#1a56db;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2">
              <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
          </button>
          <div x-show="open" @click.away="open = false"
               style="position:absolute;right:0;top:44px;background:#fff;border:1px solid #e5e7eb;border-radius:10px;box-shadow:0 4px 16px rgba(0,0,0,0.1);min-width:180px;z-index:100;padding:8px 0;">
            <div style="padding:10px 16px;border-bottom:1px solid #f3f4f6;">
              <p style="font-size:13px;font-weight:600;color:#111;"><?php echo e(auth()->user()->name); ?></p>
              <p style="font-size:11px;color:#9ca3af;"><?php echo e(auth()->user()->email); ?></p>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->isAdmin()): ?>
              <a href="<?php echo e(route('admin.index')); ?>" style="display:block;padding:10px 16px;font-size:13px;color:#374151;text-decoration:none;">⚙️ Panel admin</a>
            <?php elseif(auth()->user()->isSeller()): ?>
              <a href="<?php echo e(route('vendor.index')); ?>" style="display:block;padding:10px 16px;font-size:13px;color:#374151;text-decoration:none;">📦 Mis lotes</a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <a href="<?php echo e(route('profile.index')); ?>" style="display:block;padding:10px 16px;font-size:13px;color:#374151;text-decoration:none;">👤 Mi perfil</a>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
              <?php echo csrf_field(); ?>
              <button type="submit" style="width:100%;padding:10px 16px;font-size:13px;color:#ef4444;text-align:left;background:none;border:none;cursor:pointer;">
                → Salir
              </button>
            </form>
          </div>
        </div>
      <?php else: ?>
        <a href="<?php echo e(route('login')); ?>" class="btn-ghost">Iniciar sesión</a>
        <a href="<?php echo e(route('register')); ?>" class="btn-blue">Registrarse</a>
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
  </div>
</nav>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
<div style="position:fixed;top:70px;right:20px;z-index:200;padding:12px 18px;border-radius:8px;font-size:13px;font-weight:500;box-shadow:0 4px 16px rgba(0,0,0,.1);background:#f0fdf4;border:1px solid #86efac;color:#166634;">
  ✓ <?php echo e(session('success')); ?>

</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
<div style="position:fixed;top:70px;right:20px;z-index:200;padding:12px 18px;border-radius:8px;font-size:13px;font-weight:500;box-shadow:0 4px 16px rgba(0,0,0,.1);background:#fef2f2;border:1px solid #fca5a5;color:#991b1b;">
  <?php echo e(session('error')); ?>

</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<main><?php echo $__env->yieldContent('content'); ?></main>

<footer class="footer">
  <div class="footer-top">
    <div>
      <div class="footer-brand-logo">
        <div class="footer-brand-box"><span>R</span></div>
        <span class="footer-brand-name">RialBids</span>
      </div>
      <p class="footer-brand-desc">Marketplace de subastas online. Objetos únicos disponibles cada semana, verificados por expertos.</p>
    </div>
    <div>
      <div class="footer-col-title">Comprar</div>
      <a href="<?php echo e(route('pages.como-comprar')); ?>" class="footer-link">Cómo comprar</a>
      <a href="#" class="footer-link">Protección al comprador</a>
      <a href="#" class="footer-link">Preguntas frecuentes</a>
      <a href="#" class="footer-link">Métodos de pago</a>
    </div>
    <div>
      <div class="footer-col-title">Vender</div>
      <a href="<?php echo e(route('vendor.create')); ?>" class="footer-link">Cómo vender</a>
      <a href="#" class="footer-link">Comisiones</a>
      <a href="#" class="footer-link">Verificación</a>
    </div>
    <div>
      <div class="footer-col-title">Legal</div>
      <a href="<?php echo e(route('pages.terminos')); ?>" class="footer-link">Términos y condiciones</a>
      <a href="<?php echo e(route('pages.privacidad')); ?>" class="footer-link">Política de privacidad</a>
      <a href="#" class="footer-link">Cookies</a>
    </div>
  </div>
  <div class="footer-bottom">
    <span class="footer-copy">© <?php echo e(date('Y')); ?> RialBids. Todos los derechos reservados.</span>
    <a href="<?php echo e(route('admin.index')); ?>" class="footer-admin">Panel admin</a>
  </div>
</footer>

<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /home/u396549633/domains/rialbids.com/public_html/resources/views/layouts/app.blade.php ENDPATH**/ ?>