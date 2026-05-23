<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title>Subir fotos — RialBids</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: -apple-system, sans-serif; background: #f9fafb; color: #111; padding: 16px; }
.header { text-align: center; padding: 20px 0 24px; }
.logo { font-size: 22px; font-weight: 800; color: #1a56db; letter-spacing: -0.5px; }
.subtitle { font-size: 13px; color: #6b7280; margin-top: 4px; }
.counter { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 20px; padding: 6px 16px; font-size: 13px; font-weight: 600; color: #1d4ed8; display: inline-block; margin-top: 10px; }
.grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-bottom: 20px; }
.slot { aspect-ratio: 1; border-radius: 10px; overflow: hidden; position: relative; }
.slot.empty { border: 2px dashed #d1d5db; background: #fff; display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer; }
.slot.empty span { font-size: 11px; color: #9ca3af; margin-top: 4px; }
.slot.filled img { width: 100%; height: 100%; object-fit: cover; }
.slot .del { position: absolute; top: 4px; right: 4px; background: rgba(0,0,0,0.6); border: none; border-radius: 50%; width: 24px; height: 24px; color: #fff; font-size: 14px; cursor: pointer; display: flex; align-items: center; justify-content: center; }
.badge { position: absolute; bottom: 4px; left: 4px; background: #1a56db; color: #fff; font-size: 10px; font-weight: 700; padding: 2px 6px; border-radius: 4px; }
.btn-upload { width: 100%; padding: 16px; background: #1a56db; color: #fff; border: none; border-radius: 12px; font-size: 16px; font-weight: 700; cursor: pointer; margin-bottom: 12px; }
.btn-upload:disabled { background: #9ca3af; }
.btn-camera { width: 100%; padding: 14px; background: #fff; color: #1a56db; border: 2px solid #1a56db; border-radius: 12px; font-size: 15px; font-weight: 600; cursor: pointer; margin-bottom: 20px; }
.info { background: #f0fdf4; border: 1px solid #86efac; border-radius: 10px; padding: 14px 16px; font-size: 13px; color: #166534; text-align: center; }
.loading { text-align: center; padding: 8px; font-size: 13px; color: #6b7280; display: none; }
.req { font-size: 11px; color: #9ca3af; text-align: center; margin-bottom: 16px; }
</style>
</head>
<body>
<div class="header">
  <div class="logo">R RialBids</div>
  <div class="subtitle">Subí las fotos de tu lote desde el celular</div>
  <div class="counter" id="counter">0 / 6 fotos</div>
</div>

<div class="req">Mínimo 3 fotos obligatorias · Máximo 6</div>

<div class="grid" id="grid"></div>

<div class="loading" id="loading">Subiendo foto...</div>

<button class="btn-upload" id="btnGaleria" onclick="document.getElementById('fileGaleria').click()">
  📷 Elegir de la galería
</button>
<button class="btn-camera" onclick="document.getElementById('fileCamera').click()">
  📸 Sacar foto ahora
</button>

<input type="file" id="fileGaleria" accept="image/*" multiple style="display:none" onchange="uploadFiles(this.files)">
<input type="file" id="fileCamera" accept="image/*" capture="environment" style="display:none" onchange="uploadFiles(this.files)">

<div class="info" id="infoMsg" style="display:none">
  ✅ ¡Fotos listas! Podés cerrar esta página y volver a tu computadora.
</div>

<script>
const TOKEN = '{{ $token }}';
const BASE  = '/mobile-upload/' + TOKEN;
let photos  = @json($photos);

function render() {
  const grid = document.getElementById('grid');
  grid.innerHTML = '';
  for (let i = 0; i < 6; i++) {
    const slot = document.createElement('div');
    slot.className = 'slot ' + (photos[i] ? 'filled' : 'empty');
    if (photos[i]) {
      slot.innerHTML = `
        <img src="/storage/${photos[i]}">
        <button class="del" onclick="deletePhoto(${i})">×</button>
        <span class="badge">${i === 0 ? 'Principal' : i+1}</span>
      `;
    } else {
      slot.innerHTML = `
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/></svg>
        <span>Foto ${i+1}${i < 3 ? ' *' : ''}</span>
      `;
      slot.onclick = () => document.getElementById('fileGaleria').click();
    }
    grid.appendChild(slot);
  }
  document.getElementById('counter').textContent = photos.length + ' / 6 fotos';
  document.getElementById('infoMsg').style.display = photos.length >= 3 ? 'block' : 'none';
  document.getElementById('btnGaleria').disabled = photos.length >= 6;
}

async function uploadFiles(files) {
  for (con

python3 << 'EOF'
path = '/home/u396549633/domains/rialbids.com/public_html/routes/web.php'
with open(path, 'r') as f:
    content = f.read()

old = "Route::post('/webhook/stripe', [PaymentController::class, 'webhook'])->name('payment.webhook');"
new = """Route::post('/webhook/stripe', [PaymentController::class, 'webhook'])->name('payment.webhook');

// Mobile upload (sin auth, solo token)
Route::get('/mobile-upload/{token}', [\\App\\Http\\Controllers\\MobileUploadController::class, 'page'])->name('mobile.upload.page');
Route::post('/mobile-upload/{token}/upload', [\\App\\Http\\Controllers\\MobileUploadController::class, 'upload'])->name('mobile.upload.photo');
Route::get('/mobile-upload/{token}/status', [\\App\\Http\\Controllers\\MobileUploadController::class, 'status'])->name('mobile.upload.status');
Route::post('/mobile-upload/{token}/delete', [\\App\\Http\\Controllers\\MobileUploadController::class, 'delete'])->name('mobile.upload.delete');"""

content = content.replace(old, new)
with open(path, 'w') as f:
    f.write(content)
print("OK routes")
