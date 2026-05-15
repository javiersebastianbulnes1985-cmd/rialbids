<?php $__env->startSection('title', $auction->title . ' — RialBids'); ?>
<?php $__env->startSection('content'); ?>
<?php
$ytId=null;
if(!empty($auction->video_url)){preg_match('/(?:youtube\.com\/.*[?&]v=|youtu\.be\/)([^"&?\/]{11})/i',$auction->video_url,$m);$ytId=$m[1]??null;}
$imgs=[];
if(!empty($auction->image_path))$imgs[]=asset('storage/'.$auction->image_path);
if(!empty($auction->image_path_2))$imgs[]=asset('storage/'.$auction->image_path_2);
if(!empty($auction->image_path_3))$imgs[]=asset('storage/'.$auction->image_path_3);
if(empty($imgs)&&$ytId)$imgs[]="https://img.youtube.com/vi/{$ytId}/hqdefault.jpg";
$ef=$auction->end_time??$auction->ends_at??null;
$sl=$ef?max(0,\Carbon\Carbon::parse($ef)->timestamp-now()->timestamp):0;
$ended=$sl<=0||$auction->status==='finished';
$cp=$auction->current_price??$auction->base_price??0;
$mi=$auction->min_increment??50;
$nb=$cp+$mi;$q1=$nb;$q2=$nb+$mi;$q3=$nb+($mi*4);
$specs=[];
if(!empty($auction->technical_specs))$specs=is_array($auction->technical_specs)?$auction->technical_specs:(json_decode($auction->technical_specs,true)??[]);
$rm=!isset($auction->reserve_price)||!$auction->reserve_price||$cp>=$auction->reserve_price;
$catName=$auction->category->name??'General';
$esGanador=$ended&&$auction->winner_id&&auth()->id()===$auction->winner_id;
?>

<div style="max-width:1280px;margin:0 auto;padding:24px 20px;">

  
  <div style="font-size:13px;color:#6b7280;margin-bottom:20px;">
    <a href="<?php echo e(route('home')); ?>" style="color:#1a56db;text-decoration:none;">Subastas</a>
    <span style="margin:0 6px;">›</span>
    <span style="color:#6b7280;"><?php echo e($catName); ?></span>
    <span style="margin:0 6px;">›</span>
    <span style="color:#111;"><?php echo e(Str::limit($auction->title,40)); ?></span>
  </div>

  <div style="display:grid;grid-template-columns:1fr 360px;gap:28px;align-items:flex-start;">

    
    <div>
      <h1 style="font-size:24px;font-weight:700;color:#111827;margin-bottom:6px;"><?php echo e($auction->title); ?></h1>
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
        <span style="background:#eff6ff;color:#1a56db;font-size:12px;font-weight:600;padding:3px 10px;border-radius:20px;"><?php echo e($catName); ?></span>
        <span style="font-size:12px;color:#9ca3af;">Lote #<?php echo e(str_pad($auction->id,4,'0',STR_PAD_LEFT)); ?></span>
        <span style="font-size:12px;color:#9ca3af;">👁 <?php echo e($auction->views_count ?? 0); ?> visitas</span>
      </div>

      
      <div style="border-radius:12px;overflow:hidden;background:#f9fafb;margin-bottom:20px;">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($imgs)>0): ?>
          <div style="aspect-ratio:4/3;position:relative;" id="main-img-wrap">
            <img id="main-img" src="<?php echo e($imgs[0]); ?>" style="width:100%;height:100%;object-fit:cover;">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ytId&&count($imgs)==1): ?>
              <div onclick="document.getElementById('main-img-wrap').innerHTML='<iframe src=\'https://www.youtube.com/embed/<?php echo e($ytId); ?>?autoplay=1\' style=\'width:100%;height:100%;border:none;\' allowfullscreen></iframe>'"
                   style="position:absolute;inset:0;background:rgba(0,0,0,.25);display:flex;align-items:center;justify-content:center;cursor:pointer;">
                <div style="width:64px;height:64px;background:rgba(255,255,255,.95);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                  <svg style="width:26px;height:26px;fill:#1a56db;margin-left:4px;" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                </div>
              </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </div>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($imgs)>1): ?>
            <div style="display:flex;gap:8px;padding:12px;">
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $imgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <img src="<?php echo e($img); ?>"
                     onclick="document.getElementById('main-img').src='<?php echo e($img); ?>';document.querySelectorAll('.thumb-btn').forEach(t=>t.style.borderColor='#e5e7eb');this.style.borderColor='#1a56db'"
                     class="thumb-btn"
                     style="width:72px;height:72px;object-fit:cover;border-radius:8px;cursor:pointer;border:2px solid <?php echo e($i==0?'#1a56db':'#e5e7eb'); ?>;">
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php else: ?>
          <div style="aspect-ratio:4/3;display:flex;align-items:center;justify-content:center;background:#f3f4f6;">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5">
              <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/>
            </svg>
          </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>

      
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($auction->description): ?>
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:20px;margin-bottom:16px;">
          <h2 style="font-size:14px;font-weight:600;color:#111827;margin-bottom:10px;">Descripción</h2>
          <p style="font-size:14px;color:#374151;line-height:1.65;"><?php echo e($auction->description); ?></p>
        </div>
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

      
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($specs)): ?>
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
          <div style="padding:16px 20px;border-bottom:1px solid #f3f4f6;">
            <h2 style="font-size:14px;font-weight:600;color:#111827;">Detalles del lote</h2>
          </div>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $specs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($v): ?>
              <div style="display:flex;padding:11px 20px;border-bottom:1px solid #f9fafb;">
                <span style="font-size:12px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.06em;width:160px;flex-shrink:0;"><?php echo e($k); ?></span>
                <span style="font-size:13px;color:#111827;font-weight:500;"><?php echo e($v); ?></span>
              </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <div style="position:sticky;top:76px;">

      
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$ended): ?>
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:16px 20px;margin-bottom:12px;">
          <p style="font-size:11px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:10px;">Subasta cierra en</p>
          <div style="display:flex;align-items:center;gap:10px;" id="cd" data-seconds="<?php echo e($sl); ?>">
            <div style="text-align:center;flex:1;background:#f9fafb;border-radius:8px;padding:10px 4px;">
              <div id="cd-d" style="font-size:24px;font-weight:700;color:#111827;">--</div>
              <div style="font-size:10px;color:#9ca3af;text-transform:uppercase;margin-top:2px;">Días</div>
            </div>
            <div style="color:#d1d5db;font-size:20px;">:</div>
            <div style="text-align:center;flex:1;background:#f9fafb;border-radius:8px;padding:10px 4px;">
              <div id="cd-h" style="font-size:24px;font-weight:700;color:#111827;">--</div>
              <div style="font-size:10px;color:#9ca3af;text-transform:uppercase;margin-top:2px;">Horas</div>
            </div>
            <div style="color:#d1d5db;font-size:20px;">:</div>
            <div style="text-align:center;flex:1;background:#f9fafb;border-radius:8px;padding:10px 4px;">
              <div id="cd-m" style="font-size:24px;font-weight:700;color:#111827;">--</div>
              <div style="font-size:10px;color:#9ca3af;text-transform:uppercase;margin-top:2px;">Min</div>
            </div>
            <div style="color:#d1d5db;font-size:20px;">:</div>
            <div style="text-align:center;flex:1;background:#f9fafb;border-radius:8px;padding:10px 4px;">
              <div id="cd-s" style="font-size:24px;font-weight:700;color:#111827;">--</div>
              <div style="font-size:10px;color:#9ca3af;text-transform:uppercase;margin-top:2px;">Seg</div>
            </div>
          </div>
        </div>
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

      
      <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;margin-bottom:12px;">
        <div style="padding:20px;border-bottom:1px solid #f3f4f6;">
          <p style="font-size:11px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:6px;">
            <?php echo e($ended ? 'Precio final' : 'Oferta actual'); ?>

          </p>
          <p style="font-size:36px;font-weight:700;color:#111827;line-height:1;">€<?php echo e(number_format($cp,0,',','.')); ?></p>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$ended && !$rm): ?>
            <p style="font-size:12px;color:#f59e0b;margin-top:6px;">⚠ Precio de reserva no alcanzado</p>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ended): ?>
            <span style="display:inline-block;margin-top:8px;background:#f3f4f6;color:#6b7280;font-size:12px;font-weight:600;padding:4px 12px;border-radius:20px;">SUBASTA CERRADA</span>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$ended): ?>
          <div style="padding:16px;">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!auth()->check()): ?>
              <div style="text-align:center;padding:12px 0;">
                <p style="font-size:13px;color:#6b7280;margin-bottom:12px;">Inicia sesión para realizar una oferta</p>
                <a href="<?php echo e(route('login')); ?>" style="display:block;width:100%;padding:14px;background:#111827;color:#fff;border-radius:8px;font-size:15px;font-weight:600;text-align:center;text-decoration:none;">Iniciar sesión</a>
                <p style="font-size:12px;color:#9ca3af;margin-top:8px;">¿No tienes cuenta? <a href="<?php echo e(route('register')); ?>" style="color:#1a56db;">Regístrate gratis</a></p>
              </div>
            <?php else: ?>
              <div style="display:flex;gap:8px;margin-bottom:12px;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [$q1,$q2,$q3]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <button onclick="document.getElementById('bid-amount').value=<?php echo e($qb); ?>"
                          style="flex:1;padding:9px 4px;border:1.5px solid #e5e7eb;border-radius:8px;background:#fff;font-size:13px;font-weight:600;color:#374151;cursor:pointer;"
                          onmouseover="this.style.borderColor='#1a56db';this.style.color='#1a56db';this.style.background='#eff6ff'"
                          onmouseout="this.style.borderColor='#e5e7eb';this.style.color='#374151';this.style.background='#fff'">
                    €<?php echo e(number_format($qb,0,',','.')); ?>

                  </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </div>
              <form action="<?php echo e(route('auctions.bid',$auction->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div style="position:relative;margin-bottom:12px;">
                  <span style="position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#6b7280;font-weight:600;font-size:15px;">€</span>
                  <input type="number" id="bid-amount" name="amount" value="<?php echo e($nb); ?>" min="<?php echo e($nb); ?>" step="1"
                         style="width:100%;padding:13px 13px 13px 28px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:16px;font-weight:600;outline:none;"
                         onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e5e7eb'">
                </div>
                <button type="submit"
                        style="width:100%;padding:14px;background:#111827;color:#fff;border:none;border-radius:8px;font-size:15px;font-weight:600;cursor:pointer;margin-bottom:8px;"
                        onmouseover="this.style.background='#1f2937'" onmouseout="this.style.background='#111827'">
                  Realizar oferta
                </button>
              </form>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
              <div style="background:#f0fdf4;border:1px solid #86efac;color:#166534;padding:10px;border-radius:8px;font-size:13px;text-align:center;margin-top:8px;">
                ✓ <?php echo e(session('success')); ?>

              </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
              <div style="background:#fef2f2;border:1px solid #fca5a5;color:#991b1b;padding:10px;border-radius:8px;font-size:13px;text-align:center;margin-top:8px;">
                <?php echo e(session('error')); ?>

              </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div style="display:flex;justify-content:space-between;margin-top:12px;padding-top:12px;border-top:1px solid #f3f4f6;font-size:12px;color:#9ca3af;">
              <span>🔨 <?php echo e($auction->total_bids??0); ?> ofertas</span>
              <span>🛡 Anti-sniping activo</span>
            </div>
          </div>
        <?php else: ?>
          
          <div style="padding:20px;">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($auction->winner_id): ?>
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($esGanador): ?>
                <div style="background:#f0fdf4;border:1px solid #86efac;border-radius:10px;padding:16px;text-align:center;margin-bottom:16px;">
                  <p style="font-size:20px;margin-bottom:4px;">🎉</p>
                  <p style="font-size:15px;font-weight:700;color:#166534;">¡Felicidades, ganaste!</p>
                  <p style="font-size:13px;color:#166534;margin-top:4px;">Precio final: €<?php echo e(number_format($auction->final_price??$cp,0,',','.')); ?></p>
                </div>
                <a href="<?php echo e(route('payment.checkout', $auction->id)); ?>"
                   style="display:block;width:100%;padding:14px;background:#111827;color:#fff;border-radius:8px;font-size:15px;font-weight:600;text-align:center;text-decoration:none;margin-bottom:8px;"
                   onmouseover="this.style.background='#1f2937'" onmouseout="this.style.background='#16a34a'">
                  Proceder al pago →
                </a>
              <?php else: ?>
                <div style="text-align:center;padding:8px 0 16px;">
                  <p style="font-size:14px;color:#6b7280;">Esta subasta ha finalizado</p>
                  <p style="font-size:13px;color:#9ca3af;margin-top:4px;"><?php echo e($auction->total_bids??0); ?> ofertas · Precio final: €<?php echo e(number_format($auction->final_price??$cp,0,',','.')); ?></p>
                </div>
              <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php else: ?>
              <div style="text-align:center;padding:8px 0;">
                <p style="font-size:14px;color:#6b7280;">Sin ofertas — subasta cerrada</p>
              </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>

      
      <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:12px;padding:14px;font-size:13px;color:#1e40af;">
        <div style="font-weight:600;margin-bottom:4px;">🛡 Protección al comprador</div>
        <div style="font-size:12px;color:#3b82f6;">Tu pago está seguro · Tarifa: 9% + €3</div>
      </div>

      
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($bids)&&$bids->count()>0): ?>
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;margin-top:12px;">
          <div style="padding:12px 16px;border-bottom:1px solid #f3f4f6;font-size:13px;font-weight:600;color:#111827;">
            🔨 <?php echo e($bids->count()); ?> ofertas recientes
          </div>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $bids->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:11px 16px;border-bottom:1px solid #f9fafb;">
              <span style="font-size:13px;color:#6b7280;">Postor #<?php echo e($loop->iteration); ?></span>
              <div style="text-align:right;">
                <div style="font-size:14px;font-weight:600;color:#111827;">€<?php echo e(number_format($bid->amount,0,',','.')); ?></div>
                <div style="font-size:11px;color:#9ca3af;"><?php echo e($bid->created_at->diffForHumans()); ?></div>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
  </div>
</div>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($related) && $related->count() > 0): ?>
<div style="max-width:1280px;margin:40px auto;padding:0 24px 48px;">
  <h2 style="font-size:18px;font-weight:700;color:#111;margin-bottom:20px;">Lotes similares</h2>
  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
      $rimg=null;
      if(!empty($rel->image_path)) $rimg=asset('storage/'.$rel->image_path);
      elseif(!empty($rel->image_path_2)) $rimg=asset('storage/'.$rel->image_path_2);
      $rcp=$rel->current_price??$rel->base_price??0;
    ?>
    <a href="<?php echo e(route('auctions.show',$rel->id)); ?>" style="display:block;background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;text-decoration:none;transition:box-shadow .2s;"
       onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.10)'"
       onmouseout="this.style.boxShadow='none'">
      <div style="aspect-ratio:4/3;background:#f3f4f6;">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rimg): ?>
          <img src="<?php echo e($rimg); ?>" style="width:100%;height:100%;object-fit:cover;">
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>
      <div style="padding:12px;">
        <p style="font-size:13px;font-weight:600;color:#111;margin-bottom:6px;"><?php echo e(Str::limit($rel->title,40)); ?></p>
        <p style="font-size:16px;font-weight:700;color:#1a56db;">€<?php echo e(number_format($rcp,0,',','.')); ?></p>
      </div>
    </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<script>
const cd=document.getElementById('cd');
if(cd){
  let s=parseInt(cd.dataset.seconds);
  const f=n=>String(n).padStart(2,'0');
  function tick(){
    if(s<=0){cd.innerHTML='<span style="color:#ef4444;font-weight:600;">¡Subasta finalizada!</span>';return;}
    document.getElementById('cd-d').textContent=f(Math.floor(s/86400));
    document.getElementById('cd-h').textContent=f(Math.floor((s%86400)/3600));
    document.getElementById('cd-m').textContent=f(Math.floor((s%3600)/60));
    document.getElementById('cd-s').textContent=f(s%60);
    if(s<3600){['cd-d','cd-h','cd-m','cd-s'].forEach(id=>{document.getElementById(id).style.color='#ef4444'});}
    s--;
  }
  tick();setInterval(tick,1000);
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u396549633/domains/rialbids.com/public_html/resources/views/auctions/show.blade.php ENDPATH**/ ?>