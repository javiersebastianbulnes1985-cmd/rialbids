<?php $__env->startSection('title','RialBids — Subastas Online'); ?>
<?php $__env->startSection('content'); ?>

<?php
  $categorias = [
    'general'       => 'General',
    'arte'          => 'Arte',
    'joyas'         => 'Joyas',
    'relojes'       => 'Relojes',
    'coleccionismo' => 'Coleccionismo',
    'electronica'   => 'Electrónica',
    'muebles'       => 'Antigüedades',
  ];
  $catActual = request('categoria','');
  $busqueda  = request('q','');
?>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($banner) && $banner): ?>
<div style="position:relative;width:100%;height:420px;overflow:hidden;background:#1a56db;">
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($banner->imagen_path): ?>
    <img src="<?php echo e(asset('storage/'.$banner->imagen_path)); ?>"
         style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;">
    <div style="position:absolute;inset:0;background:rgba(0,0,0,0.45);"></div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  <div style="position:relative;z-index:2;max-width:1280px;margin:0 auto;padding:0 24px;height:100%;display:flex;flex-direction:column;justify-content:center;">
    <p style="font-size:12px;font-weight:600;color:rgba(255,255,255,0.8);text-transform:uppercase;letter-spacing:0.1em;margin:0 0 12px;">Subasta destacada</p>
    <h1 style="font-size:42px;font-weight:700;color:#fff;margin:0 0 12px;line-height:1.15;max-width:600px;"><?php echo e($banner->titulo); ?></h1>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($banner->subtitulo): ?>
      <p style="font-size:16px;color:rgba(255,255,255,0.85);margin:0 0 28px;"><?php echo e($banner->subtitulo); ?></p>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($banner->link): ?>
      <a href="<?php echo e($banner->link); ?>"
         style="display:inline-flex;align-items:center;gap:8px;padding:13px 28px;background:#fff;color:#111827;border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;width:fit-content;">
        <?php echo e($banner->link_texto); ?> →
      </a>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </div>
</div>
<?php else: ?>
<div style="background:#1a56db;padding:22px 24px;">
  <div style="max-width:1280px;margin:0 auto;display:flex;justify-content:space-between;align-items:center;">
    <div>
      <h1 style="font-size:22px;font-weight:700;color:#fff;margin:0;">Subastas en Vivo</h1>
      <p style="font-size:13px;color:rgba(255,255,255,0.8);margin:5px 0 0;"><?php echo e($auctions->count()); ?> lotes activos disponibles ahora</p>
    </div>
    <div style="display:flex;align-items:center;gap:7px;">
      <div style="width:8px;height:8px;background:#4ade80;border-radius:50%;"></div>
      <span style="font-size:13px;color:rgba(255,255,255,0.85);">En vivo</span>
    </div>
  </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


<div style="max-width:1280px;margin:24px auto;padding:0 24px;display:flex;gap:24px;align-items:flex-start;">

  
  <div style="width:200px;flex-shrink:0;">
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">
      <div style="padding:14px 16px;border-bottom:1px solid #f3f4f6;">
        <p style="font-size:12px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.08em;margin:0;">Categorías</p>
      </div>
      <div style="padding:8px 0;">
        <a href="<?php echo e(route('home')); ?>"
           style="display:flex;justify-content:space-between;align-items:center;padding:9px 16px;text-decoration:none;font-size:13px;font-weight:<?php echo e($catActual===''?'700':'500'); ?>;color:<?php echo e($catActual===''?'#1a56db':'#374151'); ?>;background:<?php echo e($catActual===''?'#eff6ff':'transparent'); ?>;">
          <span>Todos</span>
          <span style="background:#f3f4f6;color:#6b7280;font-size:11px;font-weight:600;padding:2px 8px;border-radius:20px;"><?php echo e($auctions->count()); ?></span>
        </a>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slug => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php $count = $auctions->where('lot_category', $slug)->count(); ?>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($count > 0): ?>
          <a href="<?php echo e(route('home', ['categoria' => $slug])); ?>"
             style="display:flex;justify-content:space-between;align-items:center;padding:9px 16px;text-decoration:none;font-size:13px;font-weight:<?php echo e($catActual===$slug?'700':'500'); ?>;color:<?php echo e($catActual===$slug?'#1a56db':'#374151'); ?>;background:<?php echo e($catActual===$slug?'#eff6ff':'transparent'); ?>;">
            <span><?php echo e($nombre); ?></span>
            <span style="background:#f3f4f6;color:#6b7280;font-size:11px;font-weight:600;padding:2px 8px;border-radius:20px;"><?php echo e($count); ?></span>
          </a>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>
    </div>
  </div>

  
  <div style="flex:1;min-width:0;">

    <?php
      $filtered = $catActual ? $auctions->where('lot_category', $catActual) : $auctions;
      if($busqueda) $filtered = $filtered->filter(fn($a) => str_contains(strtolower($a->title), strtolower($busqueda)));
    ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filtered->isEmpty()): ?>
      <div style="text-align:center;padding:60px 0;color:#9ca3af;">
        <p style="font-size:16px;">No hay subastas en esta categoría.</p>
        <a href="<?php echo e(route('home')); ?>" style="color:#1a56db;font-size:13px;">Ver todas →</a>
      </div>
    <?php else: ?>
      <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $filtered; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            $img = null;
            if(!empty($auction->image_path)) $img = asset('storage/'.$auction->image_path);
            elseif(!empty($auction->image_path_2)) $img = asset('storage/'.$auction->image_path_2);
            elseif(!empty($auction->video_url)){
              preg_match('/[?&]v=([^&]+)/i',$auction->video_url,$mm);
              if(!empty($mm[1])) $img = "https://img.youtube.com/vi/{$mm[1]}/hqdefault.jpg";
            }
            $ef    = $auction->end_time ?? $auction->ends_at ?? null;
            $sl    = $ef ? max(0, \Carbon\Carbon::parse($ef)->timestamp - now()->timestamp) : 0;
            $d     = floor($sl/86400);
            $hh    = floor(($sl%86400)/3600);
            $mm2   = floor(($sl%3600)/60);
            $ss    = $sl%60;
            $ended  = $sl <= 0;
            $urgent = $sl <= 86400 && !$ended;
            $cp    = $auction->current_price ?? $auction->base_price ?? 0;
            $tb    = $auction->total_bids ?? 0;
          ?>

          <a href="<?php echo e(route('auctions.show', $auction->id)); ?>"
             style="display:block;background:#fff;border:1px solid <?php echo e($urgent?'#fca5a5':'#e5e7eb'); ?>;border-radius:10px;overflow:hidden;text-decoration:none;position:relative;transition:box-shadow .2s,transform .2s;"
             onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.10)';this.style.transform='translateY(-2px)'"
             onmouseout="this.style.boxShadow='none';this.style.transform='translateY(0)'">

            <button onclick="event.preventDefault();this.style.color=this.style.color==='#ef4444'?'#d1d5db':'#ef4444';"
                    style="position:absolute;top:10px;right:10px;z-index:10;background:rgba(255,255,255,0.9);border:none;border-radius:50%;width:32px;height:32px;cursor:pointer;color:#d1d5db;font-size:16px;display:flex;align-items:center;justify-content:center;box-shadow:0 1px 4px rgba(0,0,0,0.15);">
              ♥
            </button>

            <div style="position:relative;aspect-ratio:4/3;background:#f8f8f8;overflow:hidden;display:flex;align-items:center;justify-content:center;">
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($img): ?>
                <img src="<?php echo e($img); ?>" alt="<?php echo e($auction->title); ?>" style="width:100%;height:100%;object-fit:cover;" loading="lazy">
              <?php else: ?>
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5">
                  <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/>
                </svg>
              <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              <div style="position:absolute;top:8px;left:8px;">
                <span style="background:rgba(255,255,255,0.95);color:#1a56db;font-size:10px;font-weight:600;padding:2px 8px;border-radius:20px;">
                  <?php echo e($categorias[$auction->lot_category] ?? 'General'); ?>

                </span>
              </div>
            </div>

            <div style="padding:12px 14px;">
              <h3 style="font-size:13px;font-weight:600;color:#111827;line-height:1.4;margin-bottom:10px;min-height:36px;">
                <?php echo e(Str::limit($auction->title, 50)); ?>

              </h3>

              <div style="display:flex;justify-content:space-between;align-items:flex-end;">
                <div>
                  <p style="font-size:10px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:1px;">Puja actual</p>
                  <p style="font-size:18px;font-weight:700;color:<?php echo e($tb>0?'#16a34a':'#111827'); ?>;">€<?php echo e(number_format($cp,0,',','.')); ?></p>
                  <p style="font-size:11px;color:#9ca3af;"><?php echo e($tb); ?> <?php echo e($tb==1?'puja':'pujas'); ?></p>
                </div>
                <div style="text-align:right;">
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ended): ?>
                    <p style="font-size:12px;color:#9ca3af;">Finalizada</p>
                  <?php elseif($urgent): ?>
                    <p style="font-size:13px;font-weight:700;color:#ef4444;">
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($d>0): ?><?php echo e($d); ?>d <?php echo e(str_pad($hh,2,'0',STR_PAD_LEFT)); ?>h
                      <?php elseif($hh>0): ?><?php echo e(str_pad($hh,2,'0',STR_PAD_LEFT)); ?>:<?php echo e(str_pad($mm2,2,'0',STR_PAD_LEFT)); ?>h
                      <?php else: ?><?php echo e(str_pad($mm2,2,'0',STR_PAD_LEFT)); ?>:<?php echo e(str_pad($ss,2,'0',STR_PAD_LEFT)); ?>m
                      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </p>
                    <p style="font-size:10px;color:#ef4444;font-weight:600;">⚡ Cierra pronto</p>
                  <?php else: ?>
                    <p style="font-size:13px;font-weight:600;color:#374151;"><?php echo e($d); ?>d <?php echo e(str_pad($hh,2,'0',STR_PAD_LEFT)); ?>h</p>
                  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
              </div>
            </div>
          </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </div>
</div>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($finaliza_pronto) && $finaliza_pronto->isNotEmpty()): ?>
<div style="max-width:1280px;margin:0 auto 40px;padding:0 24px;">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
    <h2 style="font-size:18px;font-weight:700;color:#111827;margin:0;">⚡ Finaliza pronto</h2>
    <a href="<?php echo e(route('home')); ?>" style="font-size:13px;color:#1a56db;text-decoration:none;font-weight:600;">Mostrar todo →</a>
  </div>
  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $finaliza_pronto; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php
        $img = null;
        if(!empty($auction->image_path)) $img = asset('storage/'.$auction->image_path);
        elseif(!empty($auction->image_path_2)) $img = asset('storage/'.$auction->image_path_2);
        $cp = $auction->current_price ?? $auction->base_price ?? 0;
        $tb = $auction->total_bids ?? 0;
        $ef = $auction->end_time ?? null;
        $sl = $ef ? max(0, \Carbon\Carbon::parse($ef)->timestamp - now()->timestamp) : 0;
        $d  = floor($sl/86400);
        $hh = floor(($sl%86400)/3600);
        $mm2 = floor(($sl%3600)/60);
      ?>
      <a href="<?php echo e(route('auctions.show', $auction->id)); ?>"
         style="display:block;background:#fff;border:1px solid #fca5a5;border-radius:10px;overflow:hidden;text-decoration:none;transition:box-shadow .2s,transform .2s;"
         onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.10)';this.style.transform='translateY(-2px)'"
         onmouseout="this.style.boxShadow='none';this.style.transform='translateY(0)'">
        <div style="position:relative;aspect-ratio:4/3;background:#f8f8f8;overflow:hidden;display:flex;align-items:center;justify-content:center;">
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($img): ?>
            <img src="<?php echo e($img); ?>" alt="<?php echo e($auction->title); ?>" style="width:100%;height:100%;object-fit:cover;" loading="lazy">
          <?php else: ?>
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5">
              <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/>
            </svg>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <div style="padding:12px 14px;">
          <h3 style="font-size:13px;font-weight:600;color:#111827;line-height:1.4;margin-bottom:6px;"><?php echo e(Str::limit($auction->title, 50)); ?></h3>
          <p style="font-size:12px;color:#ef4444;font-weight:600;margin-bottom:4px;">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($d>0): ?><?php echo e($d); ?>d <?php echo e(str_pad($hh,2,'0',STR_PAD_LEFT)); ?>h
            <?php elseif($hh>0): ?><?php echo e(str_pad($hh,2,'0',STR_PAD_LEFT)); ?>h <?php echo e(str_pad($mm2,2,'0',STR_PAD_LEFT)); ?>m
            <?php else: ?><?php echo e(str_pad($mm2,2,'0',STR_PAD_LEFT)); ?>m restantes
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </p>
          <p style="font-size:11px;color:#9ca3af;"><?php echo e($tb); ?> <?php echo e($tb==1?'puja':'pujas'); ?></p>
          <p style="font-size:16px;font-weight:700;color:<?php echo e($tb>0?'#16a34a':'#111827'); ?>;">€<?php echo e(number_format($cp,0,',','.')); ?></p>
        </div>
      </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($recientes) && $recientes->isNotEmpty()): ?>
<div style="max-width:1280px;margin:0 auto 40px;padding:0 24px;">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
    <h2 style="font-size:18px;font-weight:700;color:#111827;margin:0;">🆕 Añadido recientemente</h2>
    <a href="<?php echo e(route('home')); ?>" style="font-size:13px;color:#1a56db;text-decoration:none;font-weight:600;">Mostrar todo →</a>
  </div>
  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $recientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php
        $img = null;
        if(!empty($auction->image_path)) $img = asset('storage/'.$auction->image_path);
        elseif(!empty($auction->image_path_2)) $img = asset('storage/'.$auction->image_path_2);
        $cp = $auction->current_price ?? $auction->base_price ?? 0;
        $tb = $auction->total_bids ?? 0;
      ?>
      <a href="<?php echo e(route('auctions.show', $auction->id)); ?>"
         style="display:block;background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;text-decoration:none;transition:box-shadow .2s,transform .2s;"
         onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.10)';this.style.transform='translateY(-2px)'"
         onmouseout="this.style.boxShadow='none';this.style.transform='translateY(0)'">
        <div style="position:relative;aspect-ratio:4/3;background:#f8f8f8;overflow:hidden;display:flex;align-items:center;justify-content:center;">
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($img): ?>
            <img src="<?php echo e($img); ?>" alt="<?php echo e($auction->title); ?>" style="width:100%;height:100%;object-fit:cover;" loading="lazy">
          <?php else: ?>
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5">
              <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/>
            </svg>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          <div style="position:absolute;top:8px;left:8px;">
            <span style="background:rgba(255,255,255,0.95);color:#1a56db;font-size:10px;font-weight:600;padding:2px 8px;border-radius:20px;">
              <?php echo e($categorias[$auction->lot_category] ?? 'General'); ?>

            </span>
          </div>
        </div>
        <div style="padding:12px 14px;">
          <h3 style="font-size:13px;font-weight:600;color:#111827;line-height:1.4;margin-bottom:6px;"><?php echo e(Str::limit($auction->title, 50)); ?></h3>
          <p style="font-size:11px;color:#9ca3af;margin-bottom:2px;"><?php echo e($tb); ?> <?php echo e($tb==1?'puja':'pujas'); ?></p>
          <p style="font-size:16px;font-weight:700;color:<?php echo e($tb>0?'#16a34a':'#111827'); ?>;">€<?php echo e(number_format($cp,0,',','.')); ?></p>
        </div>
      </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($finalizadas) && $finalizadas->isNotEmpty()): ?>
<div style="max-width:1280px;margin:0 auto 40px;padding:0 24px;">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
    <div style="display:flex;align-items:center;gap:12px;">
      <h2 style="font-size:18px;font-weight:700;color:#111827;margin:0;">Subastas Finalizadas</h2>
      <span style="background:#f3f4f6;color:#6b7280;font-size:12px;font-weight:600;padding:3px 10px;border-radius:20px;"><?php echo e($finalizadas->count()); ?></span>
    </div>
    <a href="<?php echo e(route('auctions.finalizadas')); ?>" style="font-size:13px;color:#1a56db;text-decoration:none;font-weight:600;">Ver todas →</a>
  </div>
  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $finalizadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php
        $img = null;
        if(!empty($auction->image_path)) $img = asset('storage/'.$auction->image_path);
        elseif(!empty($auction->image_path_2)) $img = asset('storage/'.$auction->image_path_2);
        $cp = $auction->current_price ?? $auction->base_price ?? 0;
        $tb = $auction->total_bids ?? 0;
        $ef = $auction->end_time ?? $auction->ends_at ?? null;
      ?>
      <a href="<?php echo e(route('auctions.show', $auction->id)); ?>"
         style="display:block;background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;text-decoration:none;opacity:0.85;transition:opacity .2s;"
         onmouseover="this.style.opacity='1'"
         onmouseout="this.style.opacity='0.85'">
        <div style="position:relative;aspect-ratio:4/3;background:#f3f4f6;overflow:hidden;display:flex;align-items:center;justify-content:center;">
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($img): ?>
            <img src="<?php echo e($img); ?>" alt="<?php echo e($auction->title); ?>" style="width:100%;height:100%;object-fit:cover;filter:grayscale(30%);" loading="lazy">
          <?php else: ?>
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5">
              <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/>
            </svg>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          <div style="position:absolute;inset:0;background:rgba(0,0,0,0.25);display:flex;align-items:center;justify-content:center;">
            <span style="background:rgba(0,0,0,0.7);color:#fff;font-size:11px;font-weight:700;padding:4px 12px;border-radius:20px;letter-spacing:0.05em;">FINALIZADA</span>
          </div>
        </div>
        <div style="padding:12px 14px;">
          <h3 style="font-size:13px;font-weight:600;color:#374151;line-height:1.4;margin-bottom:8px;"><?php echo e(Str::limit($auction->title, 50)); ?></h3>
          <div style="display:flex;justify-content:space-between;align-items:flex-end;">
            <div>
              <p style="font-size:10px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:1px;">Precio final</p>
              <p style="font-size:16px;font-weight:700;color:#6b7280;">€<?php echo e(number_format($cp,0,',','.')); ?></p>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ef): ?>
            <p style="font-size:11px;color:#9ca3af;"><?php echo e(\Carbon\Carbon::parse($ef)->format('d/m/Y')); ?></p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </div>
        </div>
      </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u396549633/domains/rialbids.com/public_html/resources/views/home.blade.php ENDPATH**/ ?>