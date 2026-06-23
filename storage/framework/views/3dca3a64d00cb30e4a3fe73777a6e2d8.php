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
    <img src="<?php echo e(asset('storage/'.$banner->imagen_path)); ?>" style="width:100%;height:100%;object-fit:contain;padding:8px;position:absolute;inset:0;">
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  <div style="position:absolute;inset:0;background:linear-gradient(90deg,rgba(0,0,0,0.65) 0%,rgba(0,0,0,0.25) 100%);z-index:1;"></div>
  <div style="position:relative;z-index:2;max-width:1280px;margin:0 auto;padding:0 24px;height:100%;display:flex;flex-direction:column;justify-content:center;">
    <span style="font-size:11px;font-weight:600;letter-spacing:.15em;color:rgba(255,255,255,0.85);text-transform:uppercase;margin-bottom:12px;"><?php echo e(__('Subasta Destacada')); ?></span>
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

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($banners) && $banners->count()): ?>
<?php $b = $banners->first(); ?>
<div style="position:relative;width:100%;height:420px;overflow:hidden;background:#0f2744;">
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($b->imagen_path): ?>
    <img src="<?php echo e(asset('storage/'.$b->imagen_path)); ?>" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;">
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  <div style="position:absolute;inset:0;background:linear-gradient(90deg,rgba(0,0,0,0.72) 0%,rgba(0,0,0,0.18) 100%);"></div>
  <div style="position:absolute;inset:0;display:flex;flex-direction:column;justify-content:center;padding:0 60px;">
    <span style="font-size:11px;font-weight:600;letter-spacing:.15em;color:rgba(255,255,255,0.7);text-transform:uppercase;margin-bottom:14px;">RialBids · Subastas Online</span>
    <h1 style="font-size:46px;font-weight:800;color:#fff;margin:0 0 14px;line-height:1.1;max-width:560px;"><?php echo e($b->titulo); ?></h1>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($b->subtitulo): ?>
      <p style="font-size:16px;color:rgba(255,255,255,0.8);margin:0 0 28px;max-width:460px;"><?php echo e($b->subtitulo); ?></p>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <a href="/auctions" style="display:inline-block;padding:13px 30px;background:#fff;color:#0f2744;border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;width:fit-content;"><?php echo e($b->link_texto ?? 'Ver subastas'); ?> &rarr;</a>
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
          <?php echo e($catFilter ? ucfirst($catFilter) : __('Resultados')); ?>

          <span style="font-size:14px;font-weight:400;color:#9ca3af;">(<?php echo e($filtered->count()); ?> <?php echo e(__('lotes')); ?>)</span>
        </h2>
        <a href="/" style="font-size:13px;color:#1a56db;text-decoration:none;"><?php echo e(__('← Volver al inicio')); ?></a>
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
            <div style="position:relative;aspect-ratio:1/1;background:#f8f8f8;overflow:hidden;">
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($img): ?>
                <img src="<?php echo e($img); ?>" alt="<?php echo e($auction->title); ?>" style="width:100%;height:100%;object-fit:contain;padding:8px;" loading="lazy">
              <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div style="padding:12px;">
              <h3 style="font-size:13px;font-weight:600;color:#111827;line-height:1.4;margin-bottom:8px;"><?php echo e($auction->title); ?></h3>
              <div style="font-size:11px;color:<?php echo e($urgent?'#ef4444':'#9ca3af'); ?>;font-weight:600;margin-bottom:4px;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sl > 0): ?> <?php echo e($d); ?>d <?php echo e($hh); ?>h <?php else: ?> <?php echo e(__('Finalizada')); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </div>
              <div style="font-size:10px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:2px;">Puja actual</div>
                <div style="font-size:16px;font-weight:700;color:#16a34a;">€<?php echo e(number_format($auction->current_price ?? $auction->base_price ?? 0, 0, ',', '.')); ?></div>
              <div style="font-size:11px;color:#9ca3af;margin-top:4px;"><?php echo e($auction->total_bids ?? 0); ?> <?php echo e(($auction->total_bids??0)==1?__('puja'):__('pujas')); ?></div>
            </div>
          </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>
      <?php else: ?>
      <div style="text-align:center;padding:80px 20px;background:#fff;border-radius:12px;">
        <h2 style="font-size:20px;font-weight:700;color:#111827;margin-bottom:8px;"><?php echo e(__('Próximamente')); ?></h2>
        <p style="font-size:14px;color:#6b7280;margin-bottom:20px;"><?php echo e(__('Estamos sumando lotes en esta categoría. Mientras tanto, mirá lo que ya tenemos disponible.')); ?></p>
        <a href="/" style="display:inline-block;background:#1a56db;color:#fff;padding:10px 24px;border-radius:6px;font-size:13px;font-weight:600;text-decoration:none;"><?php echo e(__('Ver subastas activas')); ?></a>
      </div>
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

  <?php else: ?>

    
    <div style="margin-bottom:40px;">
      <h2 style="font-size:18px;font-weight:700;color:#111;margin-bottom:20px;"><?php echo e(__('Explorar por categoría')); ?></h2>
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
        <a href="/?categoria=relojes" style="border-radius:10px;height:150px;position:relative;overflow:hidden;text-decoration:none;display:block;">
          <img src="https://images.pexels.com/photos/9978721/pexels-photo-9978721.jpeg?w=400&h=250&fit=crop" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">
          <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(10,20,50,0.85) 0%,rgba(26,58,140,0.15) 60%);display:flex;flex-direction:column;align-items:flex-start;justify-content:flex-end;padding:16px;">
            <span style="font-size:17px;font-weight:700;color:#fff;"><?php echo e(__('Relojes')); ?></span>
            <span style="font-size:12px;color:rgba(255,255,255,0.75);margin-top:2px;">8 <?php echo e(__('lotes activos')); ?></span>
          </div>
        </a>
        <a href="/?categoria=joyas" style="border-radius:10px;height:150px;position:relative;overflow:hidden;text-decoration:none;display:block;">
          <img src="https://images.pexels.com/photos/691046/pexels-photo-691046.jpeg?w=400&h=250&fit=crop" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">
          <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(10,20,50,0.85) 0%,rgba(26,58,140,0.15) 60%);display:flex;flex-direction:column;align-items:flex-start;justify-content:flex-end;padding:16px;">
            <span style="font-size:17px;font-weight:700;color:#fff;"><?php echo e(__('Joyería')); ?></span>
            <span style="font-size:12px;color:rgba(255,255,255,0.75);margin-top:2px;">7 <?php echo e(__('lotes activos')); ?></span>
          </div>
        </a>
        <a href="/?categoria=arte" style="border-radius:10px;height:150px;background:#1c3868;text-decoration:none;display:flex;align-items:flex-end;padding:16px;">
          <span style="font-size:17px;font-weight:700;color:#fff;"><?php echo e(__('Arte')); ?><br><small style="font-size:11px;font-weight:400;color:rgba(255,255,255,0.6);"><?php echo e(__('Próximamente')); ?></small></span>
        </a>
        <a href="/?categoria=coleccionismo" style="border-radius:10px;height:150px;position:relative;overflow:hidden;text-decoration:none;display:block;">
          <img src="https://images.pexels.com/photos/161963/antique-bronze-bronze-figurine-asia-161963.jpeg?w=400&h=250&fit=crop" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">
          <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(10,20,50,0.85) 0%,rgba(26,58,140,0.25) 60%);display:flex;align-items:flex-end;padding:16px;">
            <span style="font-size:17px;font-weight:700;color:#fff;"><?php echo e(__('Antigüedades')); ?><br><small style="font-size:11px;font-weight:400;color:rgba(255,255,255,0.7);"><?php echo e(__('Próximamente')); ?></small></span>
          </div>
        </a>
        <a href="/?categoria=coleccionismo" style="border-radius:10px;height:150px;position:relative;overflow:hidden;text-decoration:none;display:block;">
          <img src="https://images.pexels.com/photos/1670977/pexels-photo-1670977.jpeg?w=400&h=250&fit=crop" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">
          <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(10,20,50,0.85) 0%,rgba(26,58,140,0.25) 60%);display:flex;align-items:flex-end;padding:16px;">
            <span style="font-size:17px;font-weight:700;color:#fff;"><?php echo e(__('Coleccionismo')); ?><br><small style="font-size:11px;font-weight:400;color:rgba(255,255,255,0.7);"><?php echo e(__('Próximamente')); ?></small></span>
          </div>
        </a>
        <a href="/?categoria=otros" style="border-radius:10px;height:150px;position:relative;overflow:hidden;text-decoration:none;display:block;">
          <img src="https://images.pexels.com/photos/51383/photo-camera-subject-photographer-51383.jpeg?w=400&h=250&fit=crop" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">
          <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(10,20,50,0.85) 0%,rgba(26,58,140,0.25) 60%);display:flex;align-items:flex-end;padding:16px;">
            <span style="font-size:17px;font-weight:700;color:#fff;"><?php echo e(__('Cámaras')); ?><br><small style="font-size:11px;font-weight:400;color:rgba(255,255,255,0.7);"><?php echo e(__('Próximamente')); ?></small></span>
          </div>
        </a>
      </div>
    </div>

    
    <div style="margin-bottom:40px;">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
        <h2 style="font-size:18px;font-weight:700;color:#111;"><?php echo e(__('Subastas destacadas')); ?></h2>
        <a href="/auctions" style="font-size:13px;color:#1a56db;text-decoration:none;"><?php echo e(__('Ver todas →')); ?></a>
      </div>
      <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px;">
        <div style="background:#0f2744;border-radius:10px;overflow:hidden;">
          <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:2px;padding:8px 8px 0;">
            <div style="aspect-ratio:1/1;max-height:280px;background:#1a3a6b;border-radius:4px;overflow:hidden;"><img src="<?php echo e(asset('storage/auctions/1781839992_6a34b8782782d.jpg')); ?>" style="width:100%;height:100%;object-fit:cover;"></div>
            <div style="aspect-ratio:1/1;max-height:280px;background:#1a3a6b;border-radius:4px;overflow:hidden;"><img src="<?php echo e(asset('storage/auctions/1781837170_6a34ad72356b4.png')); ?>" style="width:100%;height:100%;object-fit:cover;"></div>
            <div style="aspect-ratio:1/1;max-height:280px;background:#1a3a6b;border-radius:4px;overflow:hidden;"><img src="<?php echo e(asset('storage/auctions/1781839216_6a34b570777d9.jpg')); ?>" style="width:100%;height:100%;object-fit:cover;"></div>
          </div>
          <div style="padding:18px 22px 22px;">
            <h4 style="font-size:19px;font-weight:700;color:#fff;margin-bottom:6px;"><?php echo e(__('Relojes Vintage')); ?></h4>
            <span style="font-size:13px;color:rgba(255,255,255,0.55);">8 <?php echo e(__('lotes activos')); ?></span>
            <a href="/auctions?categoria=relojes" style="display:inline-block;margin-top:8px;border:1px solid rgba(255,255,255,0.3);color:#fff;font-size:13px;padding:9px 20px;border-radius:4px;text-decoration:none;"><?php echo e(__('Explorar →')); ?></a>
          </div>
        </div>
        <div style="background:#0f2744;border-radius:10px;overflow:hidden;">
          <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:2px;padding:8px 8px 0;">
            <div style="aspect-ratio:1/1;max-height:280px;background:#1a3a6b;border-radius:4px;overflow:hidden;"><img src="<?php echo e(asset('storage/auctions/1780369370_6a1e47da8d059.JPG')); ?>" style="width:100%;height:100%;object-fit:cover;"></div>
            <div style="aspect-ratio:1/1;max-height:280px;background:#1a3a6b;border-radius:4px;overflow:hidden;"><img src="<?php echo e(asset('storage/auctions/1780369613_6a1e48cd3237d.PNG')); ?>" style="width:100%;height:100%;object-fit:cover;"></div>
            <div style="aspect-ratio:1/1;max-height:280px;background:#1a3a6b;border-radius:4px;overflow:hidden;"><img src="<?php echo e(asset('storage/auctions/1780370654_6a1e4cde182d7.jpg')); ?>" style="width:100%;height:100%;object-fit:cover;"></div>
          </div>
          <div style="padding:18px 22px 22px;">
            <h4 style="font-size:19px;font-weight:700;color:#fff;margin-bottom:6px;"><?php echo e(__('Joyería de Lujo')); ?></h4>
            <span style="font-size:13px;color:rgba(255,255,255,0.55);">7 <?php echo e(__('lotes activos')); ?></span>
            <a href="/auctions?categoria=joyeria" style="display:inline-block;margin-top:8px;border:1px solid rgba(255,255,255,0.3);color:#fff;font-size:13px;padding:9px 20px;border-radius:4px;text-decoration:none;"><?php echo e(__('Explorar →')); ?></a>
          </div>
        </div>
        </div>
      </div>
    </div>


    
    <div style="margin-bottom:40px;">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
        <h2 style="font-size:18px;font-weight:700;color:#111;">Subastas activas</h2>
        <a href="/auctions" style="font-size:13px;color:#1a56db;text-decoration:none;">Ver todas &rarr;</a>
      </div>
      <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $activeAuctions->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
          $lotImg = null;
          if($lot->image_path) $lotImg = asset("storage/".$lot->image_path);
          elseif($lot->image_path_2) $lotImg = asset("storage/".$lot->image_path_2);
          $lotEnd = $lot->end_time ?? $lot->ends_at ?? null;
          $lotSecs = $lotEnd ? max(0,\Carbon\Carbon::parse($lotEnd)->timestamp - now()->timestamp) : 0;
          $lotDays = floor($lotSecs/86400);
          $lotHours = floor(($lotSecs%86400)/3600);
          $lotUrgent = $lotSecs < 86400 && $lotSecs > 0;
          $lotTimer = $lotSecs > 0 ? $lotDays."d ".$lotHours."h" : "Finalizada";
          $lotColor = $lotUrgent ? "#ef4444" : "#9ca3af";
          $lotBorder = $lotUrgent ? "#fca5a5" : "#e5e7eb";
          $lotPrice = number_format($lot->current_price ?? $lot->base_price ?? 0, 0, ",", ".");
        ?>
        <a href="<?php echo e(route("auctions.show",$lot->id)); ?>"
           style="display:block;background:#fff;border:1px solid <?php echo e($lotBorder); ?>;border-radius:10px;overflow:hidden;text-decoration:none;transition:all .2s;"
           onmouseover="this.style.boxShadow=&apos;0 4px 20px rgba(0,0,0,0.10)&apos;;this.style.transform=&apos;translateY(-2px)&apos;"
           onmouseout="this.style.boxShadow=&apos;none&apos;;this.style.transform=&apos;none&apos;">
          <div style="aspect-ratio:1/1;background:#f8f8f8;overflow:hidden;">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lotImg): ?><img src="<?php echo e($lotImg); ?>" alt="<?php echo e($lot->title); ?>" style="width:100%;height:100%;object-fit:contain;padding:8px;" loading="lazy"><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </div>
          <div style="padding:12px;">
            <div style="font-size:10px;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;"><?php echo e(ucfirst($lot->lot_category ?? "")); ?></div>
            <h3 style="font-size:12px;font-weight:600;color:#111827;line-height:1.4;margin-bottom:6px;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;"><?php echo e($lot->title); ?></h3>
            <div style="font-size:11px;color:<?php echo e($lotColor); ?>;font-weight:600;margin-bottom:6px;">&#9201; <?php echo e($lotTimer); ?></div>
            <div style="display:flex;justify-content:space-between;align-items:center;">
              <div>
                <div style="font-size:10px;color:#9ca3af;">Puja actual</div>
                <div style="font-size:15px;font-weight:700;color:#16a34a;">&euro;<?php echo e($lotPrice); ?></div>
              </div>
              <div style="font-size:11px;color:#9ca3af;"><?php echo e($lot->total_bids ?? 0); ?> pujas</div>
            </div>
          </div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>
    </div>

    
    <?php
      $colecciones = [
        ['titulo' => 'Art Déco', 'ids' => [24,25,27,29]],
        ['titulo' => 'Bajo €200', 'ids' => [33,35,36,37,38,40]],
        ['titulo' => 'Piezas exclusivas', 'ids' => [23,24,25,27,29,39]],
      ];
    ?>
    <div style="margin-bottom:40px;">
      <h2 style="font-size:18px;font-weight:700;color:#111;margin-bottom:20px;"><?php echo e(__('Colecciones')); ?></h2>
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $colecciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php $citems = $activeAuctions->whereIn('id',$col['ids']); ?>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($citems->count() > 0): ?>
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:16px;">
              <h4 style="font-size:14px;font-weight:700;color:#111827;margin-bottom:10px;"><?php echo e($col['titulo']); ?> <span style="font-size:11px;font-weight:400;color:#9ca3af;">(<?php echo e($citems->count()); ?>)</span></h4>
              <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:6px;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $citems->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php $cimg = !empty($it->image_path) ? (str_starts_with($it->image_path,'http') ? $it->image_path : asset('storage/'.$it->image_path)) : null; ?>
                  <div style="aspect-ratio:1/1;background:#f8f8f8;border-radius:4px;overflow:hidden;">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cimg): ?><img src="<?php echo e($cimg); ?>" style="width:100%;height:100%;object-fit:cover;"><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </div>
            </div>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>
    </div>

    
    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:40px 32px;margin-bottom:40px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:20px;">
      <div>
        <h2 style="font-size:22px;font-weight:700;color:#111827;margin:0 0 8px;"><?php echo e(__('Tenes objetos para vender?')); ?></h2>
        <p style="font-size:14px;color:#6b7280;margin:0;"><?php echo e(__('Conecta con compradores de todo el mundo y vende tus objetos únicos.')); ?></p>
      </div>
      <div style="display:flex;gap:12px;">
        <a href="/seller-request" style="background:#1a56db;color:#fff;padding:12px 24px;border-radius:6px;font-size:14px;font-weight:600;text-decoration:none;"><?php echo e(__('Empezar a vender')); ?></a>
        <a href="/como-vender" style="background:#fff;color:#111827;border:1px solid #bfdbfe;padding:12px 24px;border-radius:6px;font-size:14px;font-weight:600;text-decoration:none;"><?php echo e(__('Como funciona')); ?></a>
      </div>
    </div>

  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

  <div style="background:#0f2744;border-radius:12px;padding:32px;margin-top:-16px;margin-bottom:0;text-align:center;">
    <h2 style="font-size:22px;font-weight:700;color:#fff;margin:0 0 8px;"><?php echo e(__('Tu primer lote, sin comisión')); ?></h2>
    <p style="font-size:14px;color:rgba(255,255,255,0.7);margin:0 0 20px;"><?php echo e(__('Registrate como vendedor y publicá tu primera subasta sin pagar comisión de venta.')); ?></p>
    <a href="/seller-request" style="display:inline-block;background:#fff;color:#0f2744;padding:10px 26px;border-radius:6px;font-size:13px;font-weight:700;text-decoration:none;"><?php echo e(__('Empezar ahora')); ?></a>
  </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u396549633/domains/rialbids.com/public_html/resources/views/home-test.blade.php ENDPATH**/ ?>