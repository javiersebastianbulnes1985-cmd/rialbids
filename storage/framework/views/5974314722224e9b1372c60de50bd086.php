<?php $__env->startSection('title','RialBids — Subastas Online'); ?>
<?php $__env->startSection('content'); ?>

<?php
  $categorias = [
    'general' => 'General',
    'arte' => 'Arte',
    'joyas' => 'Joyas',
    'relojes' => 'Relojes',
    'coleccionismo' => 'Coleccionismo',
    'electronica' => 'Electrónica',
    'muebles' => 'Antigüedades',
  ];
  $catFilter = request('categoria');
  $q = request('q');
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($banner) && $banner): ?>
<div style="position:relative;width:100%;height:380px;overflow:hidden;background:#1a56db;">
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($banner->imagen_path): ?>
    <img src="<?php echo e(asset('storage/'.$banner->imagen_path)); ?>" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;">
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  <div style="position:absolute;inset:0;background:linear-gradient(90deg,rgba(0,0,0,0.65) 0%,rgba(0,0,0,0.25) 100%);z-index:1;"></div>
  <div style="position:relative;z-index:2;max-width:1280px;margin:0 auto;padding:0 24px;height:100%;display:flex;flex-direction:column;justify-content:center;">
    <span style="font-size:11px;font-weight:600;letter-spacing:.15em;color:rgba(255,255,255,0.85);text-transform:uppercase;margin-bottom:12px;">Subasta Destacada</span>
    <h1 style="font-size:42px;font-weight:700;color:#fff;margin:0 0 12px;line-height:1.15;max-width:600px;"><?php echo e($banner->titulo); ?></h1>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($banner->subtitulo): ?>
      <p style="font-size:16px;color:rgba(255,255,255,0.85);margin:0 0 28px;"><?php echo e($banner->subtitulo); ?></p>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($banner->link): ?>
      <a href="<?php echo e($banner->link); ?>" style="display:inline-block;padding:12px 28px;background:#fff;color:#111;border-radius:8px;font-size:14px;font-weight:600;text-decoration:none;width:fit-content;">
        <?php echo e($banner->link_texto); ?> →
      </a>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<div style="max-width:1280px;margin:32px auto;padding:0 24px;">

  <?php
    $activeAuctions = $auctions->where('status','active');
    $filtered = $catFilter ? $activeAuctions->where('lot_category',$catFilter) : $activeAuctions;
    if($q){ $filtered = $filtered->filter(function($a) use($q){ return stripos($a->title,$q)!==false; }); }
  ?>

  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($catFilter || $q): ?>

    
    <div style="margin-bottom:32px;">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <h2 style="font-size:20px;font-weight:700;color:#111;">
          <?php echo e($catFilter ? ucfirst($catFilter) : 'Resultados'); ?>

          <span style="font-size:14px;font-weight:400;color:#9ca3af;">(<?php echo e($filtered->count()); ?> lotes)</span>
        </h2>
        <a href="/" style="font-size:13px;color:#1a56db;text-decoration:none;">← Volver al inicio</a>
      </div>

      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filtered->count() > 0): ?>
      <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;" class="home-cards">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $filtered; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            $img = null;
            if(!empty($auction->image_path)) $img = str_starts_with($auction->image_path, 'http') ? $auction->image_path : asset('storage/'.$auction->image_path);
            elseif(!empty($auction->image_path_2)) $img = asset('storage/'.$auction->image_path_2);
            $ef = $auction->end_time ?? $auction->ends_at ?? null;
            $sl = $ef ? max(0, \Carbon\Carbon::parse($ef)->timestamp - now()->timestamp) : 0;
            $d = floor($sl/86400);
            $hh = floor(($sl%86400)/3600);
            $urgent = $sl < 86400 && $sl > 0;
          ?>
          <a href="<?php echo e(route('auctions.show', $auction->id)); ?>"
             style="display:block;background:#fff;border:1px solid <?php echo e($urgent?'#fca5a5':'#e5e7eb'); ?>;border-radius:10px;overflow:hidden;text-decoration:none;"
             onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.10)';this.style.transform='translateY(-2px)'"
             onmouseout="this.style.boxShadow='none';this.style.transform='translateY(0)'">
            <div style="position:relative;aspect-ratio:3/2;background:#f8f8f8;overflow:hidden;">
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($img): ?>
                <img src="<?php echo e($img); ?>" alt="<?php echo e($auction->title); ?>" style="width:100%;height:100%;object-fit:cover;" loading="lazy">
              <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div style="padding:12px;">
              <h3 style="font-size:13px;font-weight:600;color:#111827;line-height:1.4;margin-bottom:8px;"><?php echo e($auction->title); ?></h3>
              <div style="font-size:11px;color:<?php echo e($urgent?'#ef4444':'#9ca3af'); ?>;font-weight:600;margin-bottom:4px;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sl > 0): ?> <?php echo e($d); ?>d <?php echo e($hh); ?>h <?php else: ?> Finalizada <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </div>
              <div style="font-size:16px;font-weight:700;color:#16a34a;">€<?php echo e(number_format($auction->current_price ?? $auction->base_price ?? 0, 0, ',', '.')); ?></div>
              <div style="font-size:11px;color:#9ca3af;margin-top:4px;"><?php echo e($auction->total_bids ?? 0); ?> <?php echo e(($auction->total_bids??0)==1?'puja':'pujas'); ?></div>
            </div>
          </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>
      <?php else: ?>
      <div style="text-align:center;padding:80px 20px;background:#fff;border-radius:12px;">
        <h2 style="font-size:18px;color:#9ca3af;margin-bottom:8px;">No hay lotes en esta categoría</h2>
        <p style="font-size:14px;color:#9ca3af;">Pronto agregaremos más lotes. <a href="/" style="color:#1a56db;">Ver todos</a></p>
      </div>
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

  <?php else: ?>

    
    <div style="margin-bottom:40px;">
      <h2 style="font-size:18px;font-weight:700;color:#111;margin-bottom:20px;">Explorar por categoría</h2>
      <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:16px;" class="home-cards">
        <a href="/?categoria=joyas" style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:24px 12px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;text-decoration:none;color:#111827;" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.10)'" onmouseout="this.style.boxShadow='none'">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#1a56db" stroke-width="1.5"><path d="M6 3h12l3 5-9 13L3 8z"/><path d="M3 8h18"/></svg>
          <span style="font-size:13px;font-weight:600;margin-top:10px;">Joyería</span>
          <span style="font-size:11px;color:#9ca3af;margin-top:2px;">Anillos, collares, pulseras</span>
        </a>
        <a href="/?categoria=arte" style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:24px 12px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;text-decoration:none;color:#111827;" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.10)'" onmouseout="this.style.boxShadow='none'">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/></svg>
          <span style="font-size:13px;font-weight:600;margin-top:10px;">Arte</span>
          <span style="font-size:11px;color:#9ca3af;margin-top:2px;">Pinturas, esculturas</span>
        </a>
        <a href="/?categoria=relojes" style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:24px 12px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;text-decoration:none;color:#111827;" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.10)'" onmouseout="this.style.boxShadow='none'">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="1.5"><circle cx="12" cy="12" r="7"/><polyline points="12,9 12,12 13.5,13.5"/></svg>
          <span style="font-size:13px;font-weight:600;margin-top:10px;">Relojes</span>
          <span style="font-size:11px;color:#9ca3af;margin-top:2px;">Vintage y de lujo</span>
        </a>
        <a href="/?categoria=muebles" style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:24px 12px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;text-decoration:none;color:#111827;" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.10)'" onmouseout="this.style.boxShadow='none'">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="1.5"><path d="M20 9V6a2 2 0 00-2-2H6a2 2 0 00-2 2v3"/><path d="M2 11a2 2 0 012-2h16a2 2 0 012 2v3H2v-3z"/><path d="M4 14v5M20 14v5"/></svg>
          <span style="font-size:13px;font-weight:600;margin-top:10px;">Antigüedades</span>
          <span style="font-size:11px;color:#9ca3af;margin-top:2px;">Muebles y decoración</span>
        </a>
        <a href="/?categoria=coleccionismo" style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:24px 12px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;text-decoration:none;color:#111827;" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.10)'" onmouseout="this.style.boxShadow='none'">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="1.5"><path d="M12 2a10 10 0 100 20A10 10 0 0012 2z"/><path d="M12 8v4l3 3"/></svg>
          <span style="font-size:13px;font-weight:600;margin-top:10px;">Coleccionismo</span>
          <span style="font-size:11px;color:#9ca3af;margin-top:2px;">Monedas, sellos, figuras</span>
        </a>
      </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filtered->count() > 0): ?>

      
      <div style="margin-bottom:40px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
          <h2 style="font-size:18px;font-weight:700;color:#111;">Más pujas</h2>
          <a href="/" style="font-size:13px;color:#1a56db;text-decoration:none;">Mostrar todo →</a>
        </div>
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;" class="home-cards">
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $filtered->sortByDesc('total_bids')->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
              $img = null;
              if(!empty($auction->image_path)) $img = str_starts_with($auction->image_path, 'http') ? $auction->image_path : asset('storage/'.$auction->image_path);
              elseif(!empty($auction->image_path_2)) $img = asset('storage/'.$auction->image_path_2);
            ?>
            <a href="<?php echo e(route('auctions.show', $auction->id)); ?>" style="display:block;background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;text-decoration:none;" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.10)';this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='none';this.style.transform='translateY(0)'">
              <div style="position:relative;aspect-ratio:3/2;background:#f8f8f8;overflow:hidden;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($img): ?>
                  <img src="<?php echo e($img); ?>" alt="<?php echo e($auction->title); ?>" style="width:100%;height:100%;object-fit:cover;" loading="lazy">
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </div>
              <div style="padding:12px;">
                <h3 style="font-size:13px;font-weight:600;color:#111827;line-height:1.4;margin-bottom:8px;"><?php echo e($auction->title); ?></h3>
                <div style="font-size:16px;font-weight:700;color:#16a34a;">€<?php echo e(number_format($auction->current_price ?? $auction->base_price ?? 0, 0, ',', '.')); ?></div>
                <div style="font-size:11px;color:#9ca3af;margin-top:4px;"><?php echo e($auction->total_bids ?? 0); ?> <?php echo e(($auction->total_bids??0)==1?'puja':'pujas'); ?></div>
              </div>
            </a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
      </div>

      
      <div style="margin-bottom:40px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
          <h2 style="font-size:18px;font-weight:700;color:#111;">Añadido recientemente</h2>
          <a href="/" style="font-size:13px;color:#1a56db;text-decoration:none;">Mostrar todo →</a>
        </div>
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;" class="home-cards">
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $filtered->sortByDesc('created_at')->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
              $img = null;
              if(!empty($auction->image_path)) $img = str_starts_with($auction->image_path, 'http') ? $auction->image_path : asset('storage/'.$auction->image_path);
              elseif(!empty($auction->image_path_2)) $img = asset('storage/'.$auction->image_path_2);
            ?>
            <a href="<?php echo e(route('auctions.show', $auction->id)); ?>" style="display:block;background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;text-decoration:none;" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.10)';this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='none';this.style.transform='translateY(0)'">
              <div style="position:relative;aspect-ratio:3/2;background:#f8f8f8;overflow:hidden;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($img): ?>
                  <img src="<?php echo e($img); ?>" alt="<?php echo e($auction->title); ?>" style="width:100%;height:100%;object-fit:cover;" loading="lazy">
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </div>
              <div style="padding:12px;">
                <h3 style="font-size:13px;font-weight:600;color:#111827;line-height:1.4;margin-bottom:8px;"><?php echo e($auction->title); ?></h3>
                <div style="font-size:16px;font-weight:700;color:#16a34a;">€<?php echo e(number_format($auction->current_price ?? $auction->base_price ?? 0, 0, ',', '.')); ?></div>
                <div style="font-size:11px;color:#9ca3af;margin-top:4px;"><?php echo e($auction->total_bids ?? 0); ?> <?php echo e(($auction->total_bids??0)==1?'puja':'pujas'); ?></div>
              </div>
            </a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
      </div>

      
      <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:40px 32px;margin-bottom:40px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:20px;">
        <div>
          <h2 style="font-size:22px;font-weight:700;color:#111827;margin:0 0 8px;">Tenes objetos para vender?</h2>
          <p style="font-size:14px;color:#6b7280;margin:0;">Conecta con compradores de todo el mundo y vende tus objetos únicos.</p>
        </div>
        <div style="display:flex;gap:12px;">
          <a href="/seller-request" style="background:#1a56db;color:#fff;padding:12px 24px;border-radius:6px;font-size:14px;font-weight:600;text-decoration:none;">Empezar a vender</a>
          <a href="/como-vender" style="background:#fff;color:#111827;border:1px solid #bfdbfe;padding:12px 24px;border-radius:6px;font-size:14px;font-weight:600;text-decoration:none;">Como funciona</a>
        </div>
      </div>

      
      <div style="margin-bottom:40px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
          <h2 style="font-size:18px;font-weight:700;color:#111;">Finaliza pronto</h2>
          <a href="/" style="font-size:13px;color:#1a56db;text-decoration:none;">Mostrar todo →</a>
        </div>
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;" class="home-cards">
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $filtered->sortBy(function($a){ return $a->end_time ?? $a->ends_at; })->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
              $img = null;
              if(!empty($auction->image_path)) $img = str_starts_with($auction->image_path, 'http') ? $auction->image_path : asset('storage/'.$auction->image_path);
              elseif(!empty($auction->image_path_2)) $img = asset('storage/'.$auction->image_path_2);
              $ef = $auction->end_time ?? $auction->ends_at ?? null;
              $sl = $ef ? max(0, \Carbon\Carbon::parse($ef)->timestamp - now()->timestamp) : 0;
              $d  = floor($sl/86400);
              $hh = floor(($sl%86400)/3600);
              $urgent = $sl < 86400 && $sl > 0;
            ?>
            <a href="<?php echo e(route('auctions.show', $auction->id)); ?>" style="display:block;background:#fff;border:1px solid <?php echo e($urgent?'#fca5a5':'#e5e7eb'); ?>;border-radius:10px;overflow:hidden;text-decoration:none;" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.10)';this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='none';this.style.transform='translateY(0)'">
              <div style="position:relative;aspect-ratio:3/2;background:#f8f8f8;overflow:hidden;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($img): ?>
                  <img src="<?php echo e($img); ?>" alt="<?php echo e($auction->title); ?>" style="width:100%;height:100%;object-fit:cover;" loading="lazy">
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </div>
              <div style="padding:12px;">
                <h3 style="font-size:13px;font-weight:600;color:#111827;line-height:1.4;margin-bottom:8px;"><?php echo e($auction->title); ?></h3>
                <div style="font-size:11px;color:<?php echo e($urgent?'#ef4444':'#9ca3af'); ?>;font-weight:600;margin-bottom:4px;">
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sl > 0): ?> <?php echo e($d); ?>d <?php echo e($hh); ?>h <?php else: ?> Finalizada <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div style="font-size:16px;font-weight:700;color:#16a34a;">€<?php echo e(number_format($auction->current_price ?? $auction->base_price ?? 0, 0, ',', '.')); ?></div>
                <div style="font-size:11px;color:#9ca3af;margin-top:4px;"><?php echo e($auction->total_bids ?? 0); ?> <?php echo e(($auction->total_bids??0)==1?'puja':'pujas'); ?></div>
              </div>
            </a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
      </div>

    <?php else: ?>
      <div style="text-align:center;padding:80px 20px;background:#fff;border-radius:12px;">
        <h2 style="font-size:18px;color:#9ca3af;margin-bottom:8px;">No hay subastas activas en este momento</h2>
        <p style="font-size:14px;color:#9ca3af;">Volvé pronto, agregamos nuevos lotes cada semana.</p>
      </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u396549633/domains/rialbids.com/public_html/resources/views/home.blade.php ENDPATH**/ ?>