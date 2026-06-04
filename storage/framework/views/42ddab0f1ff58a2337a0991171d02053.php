<?php $__env->startSection('content'); ?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&display=swap');
:root{--gold:#c9a84c;--gold-dark:#8a6820;--gold-light:#f0e8d4;--cream:#f8f4ed;--cream-dark:#e0d8c8;--ink:#1a1207;--ink-light:#8a7a5a}
.pb-body{background:var(--cream);min-height:100vh;padding:40px 16px 60px}
.pb-wrap{max-width:960px;margin:0 auto}
.pb-header{background:#fff;border:1px solid var(--cream-dark);border-radius:12px;padding:24px 28px;margin-bottom:20px;display:flex;align-items:flex-start;gap:20px;flex-wrap:wrap}
.pb-avatar{width:60px;height:60px;border-radius:50%;background:var(--ink);display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:500;color:var(--gold);font-family:'Playfair Display',Georgia,serif;flex-shrink:0;overflow:hidden}
.pb-avatar img{width:100%;height:100%;object-fit:cover}
.pb-name{font-family:'Playfair Display',Georgia,serif;font-size:20px;font-weight:500;color:var(--ink);margin:0}
.pb-since{font-size:11px;color:var(--ink-light);margin-top:3px;letter-spacing:.05em}
.pb-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px}
@media(max-width:600px){.pb-stats{grid-template-columns:repeat(2,1fr)}}
.pb-stat{background:#fff;border:1px solid var(--cream-dark);border-radius:10px;padding:16px;text-align:center}
.pb-stat-accent{border-bottom:2px solid var(--gold)}
.pb-stat-n{font-size:24px;font-weight:500;color:var(--ink);margin:0;font-family:'Playfair Display',Georgia,serif}
.pb-stat-l{font-size:10px;color:var(--ink-light);margin-top:4px;text-transform:uppercase;letter-spacing:.06em}
.tab-nav{background:#fff;border:1px solid var(--cream-dark);border-radius:10px;margin-bottom:20px;display:flex;overflow:hidden}
.tab-btn{background:none;border:none;border-bottom:2px solid transparent;padding:14px 22px;font-size:12px;font-weight:600;color:var(--ink-light);cursor:pointer;white-space:nowrap;letter-spacing:.04em;text-transform:uppercase;transition:all .2s}
.tab-btn.active{color:var(--gold-dark);border-bottom:2px solid var(--gold);background:var(--cream)}
.tab-panel{display:none}
.tab-panel.active{display:block}
.card{background:#fff;border:1px solid var(--cream-dark);border-radius:12px;overflow:hidden;margin-bottom:16px}
.card-header{padding:16px 22px;border-bottom:1px solid var(--cream-dark);display:flex;align-items:center;justify-content:space-between;background:var(--cream)}
.card-title{font-size:12px;font-weight:600;color:var(--ink);text-transform:uppercase;letter-spacing:.07em}
.compra-card{background:#fff;border:1px solid var(--cream-dark);border-radius:12px;overflow:hidden;margin-bottom:14px}
.compra-card:hover{border-color:#c9a84c}
.compra-card.pendiente{border-left:3px solid var(--gold)}
.lot-img{width:110px;height:110px;object-fit:cover;flex-shrink:0}
.lot-img-ph{width:110px;height:110px;flex-shrink:0;background:var(--cream-dark);display:flex;align-items:center;justify-content:center;font-size:28px;color:var(--ink-light)}
.table{width:100%;border-collapse:collapse}
.table th{padding:10px 18px;text-align:left;font-size:10px;font-weight:600;color:var(--ink-light);text-transform:uppercase;border-bottom:1px solid var(--cream-dark);letter-spacing:.06em}
.table td{padding:12px 18px;border-bottom:1px solid #f5f0e8;font-size:13px;color:var(--ink);vertical-align:middle}
.table tr:last-child td{border-bottom:none}
.table tr:hover td{background:#fdfaf5}
.btn-pay{background:var(--ink);color:var(--gold);padding:7px 18px;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;letter-spacing:.04em;display:inline-block}
.btn-confirm{background:#2d6a4a;color:#fff;border:none;border-radius:8px;padding:6px 14px;font-size:12px;font-weight:600;cursor:pointer}
.perfil-field{padding:14px 16px;background:var(--cream);border:1px solid var(--cream-dark);border-radius:8px;margin-bottom:10px}
.perfil-label{font-size:10px;color:var(--ink-light);margin:0 0 4px;font-weight:600;text-transform:uppercase;letter-spacing:.06em}
.perfil-val{font-size:14px;color:var(--ink);margin:0;font-weight:500}
</style>

<div class="pb-body">
<div class="pb-wrap">

  
  <div class="pb-header">
    <div class="pb-avatar">
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->avatar): ?>
        <img src="<?php echo e($user->avatar); ?>" alt="<?php echo e($user->name); ?>">
      <?php else: ?>
        <?php echo e(strtoupper(substr($user->name,0,1))); ?>

      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    <div style="flex:1;min-width:180px">
      <h1 class="pb-name"><?php echo e($user->name); ?></h1>
      <p class="pb-since"><?php echo e($user->email); ?> &nbsp;·&nbsp; Miembro desde <?php echo e($user->created_at->format('F Y')); ?></p>
    </div>
    <a href="<?php echo e(route('home')); ?>" style="background:var(--ink);color:var(--gold);padding:10px 20px;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;letter-spacing:.04em;white-space:nowrap">Explorar subastas</a>
  </div>

  
  <div class="pb-stats">
    <div class="pb-stat">
      <p class="pb-stat-n"><?php echo e($bids->count()); ?></p>
      <p class="pb-stat-l">Pujas realizadas</p>
    </div>
    <div class="pb-stat pb-stat-accent">
      <p class="pb-stat-n"><?php echo e($compras->count()); ?></p>
      <p class="pb-stat-l">Lotes ganados</p>
    </div>
    <div class="pb-stat">
      <p class="pb-stat-n" style="color:var(--gold-dark)">€<?php echo e(number_format($compras->sum('final_price') ?: $compras->sum('current_price'),0,',','.')); ?></p>
      <p class="pb-stat-l">Total invertido</p>
    </div>
  </div>

  
  <div class="tab-nav">
    <button class="tab-btn active" onclick="switchTab('compras',this)">Mis Compras</button>
    <button class="tab-btn" onclick="switchTab('historial',this)">Historial de pujas</button>
    <button class="tab-btn" onclick="switchTab('perfil',this)">Mi Perfil</button>
  </div>

  
  <div id="tab-compras" class="tab-panel active">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($compras->isEmpty()): ?>
      <div style="background:#fff;border:1px solid var(--cream-dark);border-radius:12px;padding:60px;text-align:center">
        <p style="font-family:'Playfair Display',Georgia,serif;font-size:18px;color:var(--ink);margin:0 0 8px">Todavía no ganaste ninguna subasta</p>
        <p style="font-size:13px;color:var(--ink-light);margin:0 0 24px">Participá en subastas para ver tus compras acá</p>
        <a href="<?php echo e(route('home')); ?>" class="btn-pay">Explorar subastas →</a>
      </div>
    <?php else: ?>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $compras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $compra): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php
        $deadline = $compra->updated_at->addDays(3);
        $h = max(0, now()->diffInHours($deadline, false));
        $d = max(0, now()->diffInDays($deadline, false));
        $pendiente = !in_array($compra->status, ['paid','shipped','delivered','completed']);
        $img = !empty($compra->image_path) ? (str_starts_with($compra->image_path,'http') ? $compra->image_path : asset('storage/'.$compra->image_path)) : null;
      ?>
      <div class="compra-card <?php echo e($pendiente ? 'pendiente' : ''); ?>">
        <div style="display:flex">
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($img): ?>
            <img src="<?php echo e($img); ?>" class="lot-img">
          <?php else: ?>
            <div class="lot-img-ph">◻</div>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          <div style="padding:18px 20px;flex:1">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px">
              <div>
                <a href="<?php echo e(route('auctions.show', $compra->id)); ?>" style="text-decoration:none">
                  <p style="font-size:14px;font-weight:500;color:var(--ink);margin:0;font-family:'Playfair Display',Georgia,serif"><?php echo e($compra->title); ?></p>
                </a>
                <p style="font-size:11px;color:var(--ink-light);margin:4px 0 12px;letter-spacing:.04em">Lote #<?php echo e(str_pad($compra->id,4,'0',STR_PAD_LEFT)); ?></p>
              </div>
              <p style="font-size:18px;font-weight:500;color:var(--ink);margin:0;white-space:nowrap;font-family:'Playfair Display',Georgia,serif">€<?php echo e(number_format($compra->final_price ?? $compra->current_price,0,',','.')); ?></p>
            </div>
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($compra->status === 'paid'): ?>
                <span style="background:#edf7f0;color:#2d6a4a;border:1px solid #c0dece;padding:4px 12px;border-radius:20px;font-size:11px;font-weight:600;letter-spacing:.04em">Pagado</span>
              <?php elseif($compra->status === 'shipped'): ?>
                <span style="background:#eff6ff;color:#1e40af;border:1px solid #bfdbfe;padding:4px 12px;border-radius:20px;font-size:11px;font-weight:600">En camino</span>
                <form method="POST" action="<?php echo e(route('auctions.confirm', $compra->id)); ?>" style="display:inline">
                  <?php echo csrf_field(); ?>
                  <button type="submit" class="btn-confirm">Confirmar recepción</button>
                </form>
              <?php elseif(in_array($compra->status,['delivered','completed'])): ?>
                <span style="background:#edf7f0;color:#15803d;border:1px solid #c0dece;padding:4px 12px;border-radius:20px;font-size:11px;font-weight:600">Completado</span>
              <?php else: ?>
                <span style="background:#fef9ec;color:#8a6820;border:1px solid #e0c87a;padding:4px 12px;border-radius:20px;font-size:11px;font-weight:600">Pago pendiente</span>
                <?php $deadline = $compra->updated_at->addDays(3); $horasRestantes = max(0, now()->diffInHours($deadline, false)); $d = floor($horasRestantes / 24); $h = $horasRestantes % 24; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($horasRestantes > 0): ?>
                  <span style="font-size:11px;color:#b45309;font-weight:600"><?php echo e($d > 0 ? $d.'d' : $h.'h'); ?> restantes</span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <a href="<?php echo e(route('payment.checkout', $compra->id)); ?>" class="btn-pay">Pagar ahora →</a>
              <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </div>

  
  <div id="tab-historial" class="tab-panel">
    <div class="card">
      <div class="card-header">
        <span class="card-title">Historial de pujas</span>
        <span style="font-size:11px;color:var(--ink-light)"><?php echo e($bids->count()); ?> pujas</span>
      </div>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bids->isEmpty()): ?>
        <div style="padding:48px;text-align:center;color:var(--ink-light)">
          <p style="font-family:'Playfair Display',Georgia,serif;font-size:16px;color:var(--ink)">Todavía no hiciste ninguna puja</p>
        </div>
      <?php else: ?>
        <table class="table">
          <thead>
            <tr>
              <th>Lote</th>
              <th>Tu puja</th>
              <th>Estado</th>
              <th>Fecha</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $bids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td>
                <p style="font-size:13px;font-weight:500;color:var(--ink);margin:0"><?php echo e(Str::limit($bid->auction->title ?? '—', 30)); ?></p>
                <p style="font-size:10px;color:var(--ink-light);margin:2px 0 0;letter-spacing:.04em">#<?php echo e(str_pad($bid->auction_id,4,'0',STR_PAD_LEFT)); ?></p>
              </td>
              <td style="font-size:14px;font-weight:500;color:var(--gold-dark);font-family:'Playfair Display',Georgia,serif">€<?php echo e(number_format($bid->amount,0,',','.')); ?></td>
              <td>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bid->auction && $bid->auction->current_price == $bid->amount && $bid->auction->status === 'active'): ?>
                  <span style="background:#edf7f0;color:#2d6a4a;border:1px solid #c0dece;padding:2px 9px;border-radius:20px;font-size:10px;font-weight:600">Ganando</span>
                <?php elseif($bid->auction && in_array($bid->auction->status,['finished','paid','shipped','delivered','completed']) && $bid->auction->winner_id === auth()->id()): ?>
                  <span style="background:#fef9ec;color:#8a6820;border:1px solid #e0c87a;padding:2px 9px;border-radius:20px;font-size:10px;font-weight:600">Ganado</span>
                <?php else: ?>
                  <span style="background:#fef2f2;color:#991b1b;border:1px solid #fca5a5;padding:2px 9px;border-radius:20px;font-size:10px;font-weight:600">Superado</span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </td>
              <td style="font-size:11px;color:var(--ink-light)"><?php echo e($bid->created_at->format('d/m/Y H:i')); ?></td>
              <td>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bid->auction): ?>
                  <a href="<?php echo e(route('auctions.show', $bid->auction_id)); ?>" style="font-size:12px;color:var(--gold-dark);text-decoration:none;font-weight:600">Ver →</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </tbody>
        </table>
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
  </div>

  
  <div id="tab-perfil" class="tab-panel">
    <div style="background:#fff;border:1px solid var(--cream-dark);border-radius:12px;padding:28px">
      <p style="font-family:'Playfair Display',Georgia,serif;font-size:16px;color:var(--ink);margin:0 0 20px">Mi Perfil</p>
      <div class="perfil-field">
        <p class="perfil-label">Nombre</p>
        <p class="perfil-val"><?php echo e($user->name); ?></p>
      </div>
      <div class="perfil-field">
        <p class="perfil-label">Email</p>
        <p class="perfil-val"><?php echo e($user->email); ?></p>
      </div>
      <div class="perfil-field">
        <p class="perfil-label">Miembro desde</p>
        <p class="perfil-val"><?php echo e($user->created_at->format('d/m/Y')); ?></p>
      </div>
      <div style="margin-top:24px;padding-top:20px;border-top:1px solid var(--cream-dark)">
        <p style="font-family:'Playfair Display',Georgia,serif;font-size:15px;color:var(--ink);margin:0 0 16px">Dirección de envío</p>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('address_saved')): ?>
          <div style="background:#f0fdf4;border:1px solid #86efac;border-radius:8px;padding:12px 16px;margin-bottom:16px;font-size:13px;color:#166534">✅ Dirección guardada correctamente.</div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <form method="POST" action="<?php echo e(route('profile.address')); ?>">
          <?php echo csrf_field(); ?>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px">
            <div>
              <label style="font-size:10px;font-weight:600;color:var(--ink-light);text-transform:uppercase;letter-spacing:.06em;display:block;margin-bottom:4px">Calle y número</label>
              <input type="text" name="address" value="<?php echo e(old('address', $user->address)); ?>" placeholder="Calle Mayor 14, 2B" style="width:100%;padding:9px 12px;border:1px solid var(--cream-dark);border-radius:8px;font-size:13px;background:var(--cream);box-sizing:border-box">
            </div>
            <div>
              <label style="font-size:10px;font-weight:600;color:var(--ink-light);text-transform:uppercase;letter-spacing:.06em;display:block;margin-bottom:4px">Ciudad</label>
              <input type="text" name="city" value="<?php echo e(old('city', $user->city)); ?>" placeholder="Madrid" style="width:100%;padding:9px 12px;border:1px solid var(--cream-dark);border-radius:8px;font-size:13px;background:var(--cream);box-sizing:border-box">
            </div>
            <div>
              <label style="font-size:10px;font-weight:600;color:var(--ink-light);text-transform:uppercase;letter-spacing:.06em;display:block;margin-bottom:4px">Código postal</label>
              <input type="text" name="postal_code" value="<?php echo e(old('postal_code', $user->postal_code)); ?>" placeholder="28001" style="width:100%;padding:9px 12px;border:1px solid var(--cream-dark);border-radius:8px;font-size:13px;background:var(--cream);box-sizing:border-box">
            </div>
            <div>
              <label style="font-size:10px;font-weight:600;color:var(--ink-light);text-transform:uppercase;letter-spacing:.06em;display:block;margin-bottom:4px">País</label>
              <select name="country" style="width:100%;padding:9px 12px;border:1px solid var(--cream-dark);border-radius:8px;font-size:13px;background:var(--cream);box-sizing:border-box">
                <option value="">— Seleccioná —</option>
                <option value="España" <?php echo e($user->country == 'España' ? 'selected' : ''); ?>>🇪🇸 España</option>
                <option value="Portugal" <?php echo e($user->country == 'Portugal' ? 'selected' : ''); ?>>🇵🇹 Portugal</option>
                <option value="Reino Unido" <?php echo e($user->country == 'Reino Unido' ? 'selected' : ''); ?>>🇬🇧 Reino Unido</option>
                <option value="Alemania" <?php echo e($user->country == 'Alemania' ? 'selected' : ''); ?>>🇩🇪 Alemania</option>
                <option value="Otro" <?php echo e($user->country == 'Otro' ? 'selected' : ''); ?>>🌍 Otro</option>
              </select>
            </div>
            <div style="grid-column:1/-1">
              <label style="font-size:10px;font-weight:600;color:var(--ink-light);text-transform:uppercase;letter-spacing:.06em;display:block;margin-bottom:4px">Teléfono</label>
              <input type="text" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>" placeholder="+34 600 000 000" style="width:100%;padding:9px 12px;border:1px solid var(--cream-dark);border-radius:8px;font-size:13px;background:var(--cream);box-sizing:border-box">
            </div>
          </div>
          <button type="submit" style="background:var(--ink);color:var(--gold);padding:10px 24px;border:none;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;letter-spacing:.04em">Guardar dirección</button>
        </form>
      </div>
      <div style="margin-top:24px;padding-top:20px;border-top:1px solid var(--cream-dark)">
        <form method="POST" action="<?php echo e(route('logout')); ?>">
          <?php echo csrf_field(); ?>
          <button type="submit" style="background:#fef2f2;color:#991b1b;border:1px solid #fca5a5;border-radius:8px;padding:9px 20px;font-size:12px;font-weight:600;cursor:pointer;letter-spacing:.04em">Cerrar sesión</button>
        </form>
      </div>
    </div>
  </div>

</div>
</div>

<script>
function switchTab(tab,btn){
  document.querySelectorAll('.tab-panel').forEach(p=>p.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('active'));
  document.getElementById('tab-'+tab).classList.add('active');
  if(btn) btn.classList.add('active');
}
const _tab = new URLSearchParams(window.location.search).get('tab');
if(_tab){
  const _btn = document.querySelector('.tab-btn[onclick*="'+_tab+'"]');
  switchTab(_tab, _btn);
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u396549633/domains/rialbids.com/public_html/resources/views/profile/index.blade.php ENDPATH**/ ?>