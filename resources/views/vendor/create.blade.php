@extends('layouts.app')

@section('title', 'Subir lote — RialBids')

@section('content')
<div style="max-width:760px;margin:40px auto;padding:0 20px;">

  <div style="margin-bottom:32px;">
    <h1 style="font-size:26px;font-weight:700;color:#111;margin:0 0 8px;">Subir nuevo lote</h1>
    <p style="font-size:14px;color:#6b7280;margin:0;">Cada lote es revisado por nuestro equipo antes de publicarse. Cuanto más completa sea la información, más rápido se aprueba.</p>
  </div>

  @if($errors->any())
    <div style="background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;">
      @foreach($errors->all() as $error)
        <p style="margin:4px 0;">{{ $error }}</p>
      @endforeach
    </div>
  @endif

  <form action="{{ route('vendor.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:28px;margin-bottom:20px;">
      <h2 style="font-size:15px;font-weight:700;color:#111;margin:0 0 20px;padding-bottom:12px;border-bottom:1px solid #f3f4f6;">1. Información del objeto</h2>

      <div style="margin-bottom:18px;">
        <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Título <span style="color:#ef4444;">*</span></label>
        <input type="text" name="title" value="{{ old('title') }}" placeholder="Ej: Reloj Omega Seamaster automático años 70" maxlength="120"
               style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
        <p style="font-size:11px;color:#9ca3af;margin:4px 0 0;">Sé específico: incluí marca, modelo, material y época si aplica.</p>
      </div>

      <div style="margin-bottom:18px;">
        <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Categoría <span style="color:#ef4444;">*</span></label>
        <select name="lot_category" style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
          <option value="">— Seleccioná una categoría —</option>
          <option value="joyas">Joyería (anillos, collares, pulseras)</option>
          <option value="relojes">Relojes (vintage y de lujo)</option>
          <option value="arte">Arte (pinturas, esculturas, grabados)</option>
          <option value="muebles">Antigüedades y muebles</option>
          <option value="coleccionismo">Coleccionismo (monedas, sellos, figuras)</option>
          <option value="electronica">Electrónica vintage</option>
          <option value="general">Otro</option>
        </select>
      </div>

      <div style="margin-bottom:18px;">
        <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Descripción <span style="color:#ef4444;">*</span></label>
        <textarea name="description" rows="6" placeholder="Describí el objeto en detalle: materiales, dimensiones, historia, estado, defectos visibles, procedencia..."
                  style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;resize:vertical;">{{ old('description') }}</textarea>
        <p style="font-size:11px;color:#9ca3af;margin:4px 0 0;">Mínimo 80 caracteres. Incluí cualquier defecto o señal de uso.</p>
      </div>

      <div>
        <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Estado del objeto <span style="color:#ef4444;">*</span></label>
        <select name="condition" style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
          <option value="">— Seleccioná el estado —</option>
          <option value="nuevo">Nuevo — sin uso, en caja original</option>
          <option value="excelente">Excelente — usado, sin defectos visibles</option>
          <option value="muy_bueno">Muy bueno — uso normal, desgaste mínimo</option>
          <option value="bueno">Bueno — uso visible, sin daños importantes</option>
          <option value="regular">Regular — defectos o restauraciones visibles</option>
        </select>
      </div>
    </div>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:28px;margin-bottom:20px;">
      <h2 style="font-size:15px;font-weight:700;color:#111;margin:0 0 20px;padding-bottom:12px;border-bottom:1px solid #f3f4f6;">2. Precio y duración</h2>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:18px;">
        <div>
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Precio de salida (€) <span style="color:#ef4444;">*</span></label>
          <input type="number" name="base_price" value="{{ old('base_price') }}" min="20" step="1" placeholder="Mín. €20"
                 style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
        </div>
        <div>
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Precio de reserva (€)</label>
          <input type="number" name="reserve_price" value="{{ old('reserve_price') }}" min="0" step="1" placeholder="Opcional"
                 style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
        </div>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
        <div>
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Incremento mínimo (€)</label>
          <input type="number" name="min_increment" value="{{ old('min_increment', 10) }}" min="1" step="1"
                 style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
        </div>
        <div>
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Duración <span style="color:#ef4444;">*</span></label>
          <select name="duracion" style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
            <option value="7">7 días</option>
            <option value="14" selected>14 días</option>
            <option value="21">21 días</option>
            <option value="30">30 días</option>
          </select>
        </div>
      </div>
    </div>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:28px;margin-bottom:20px;">
      <h2 style="font-size:15px;font-weight:700;color:#111;margin:0 0 20px;padding-bottom:12px;border-bottom:1px solid #f3f4f6;">3. Fotografías <span style="font-size:12px;font-weight:400;color:#6b7280;">(mínimo 3 obligatorias, máximo 6)</span></h2>
      <div style="background:#f0f9ff;border:1px solid #bae6fd;border-radius:8px;padding:14px 16px;margin-bottom:20px;">
        <p style="font-size:13px;font-weight:600;color:#0369a1;margin:0 0 6px;">Guía de fotos para aprobación rápida:</p>
        <ul style="font-size:12px;color:#0369a1;margin:0;padding-left:16px;line-height:1.8;">
          <li>Fondo neutro (blanco, gris o negro)</li>
          <li>Buena iluminación, sin sombras duras</li>
          <li>Foto principal: objeto completo y centrado</li>
          <li>Fotos adicionales: detalles, firma, defectos, reverso</li>
          <li>Sin marcas de agua ni texto encima</li>
          <li>Mínimo 800x800px recomendado</li>
        </ul>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:16px;">
        @php
          $fotosConfig = [
            ['name'=>'image',   'label'=>'Foto 1 — Principal', 'req'=>true],
            ['name'=>'image_2', 'label'=>'Foto 2',             'req'=>true],
            ['name'=>'image_3', 'label'=>'Foto 3',             'req'=>true],
            ['name'=>'image_4', 'label'=>'Foto 4',             'req'=>false],
            ['name'=>'image_5', 'label'=>'Foto 5',             'req'=>false],
            ['name'=>'image_6', 'label'=>'Foto 6',             'req'=>false],
          ];
        @endphp
        @foreach($fotosConfig as $foto)
        <div>
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">
            {{ $foto['label'] }} @if($foto['req'])<span style="color:#ef4444;">*</span>@endif
          </label>
          <div style="border:2px dashed #d1d5db;border-radius:8px;overflow:hidden;background:#fafafa;position:relative;cursor:pointer;"
               onclick="document.getElementById('{{ $foto['name'] }}_input').click()">
            <img id="{{ $foto['name'] }}_preview"
                 src="" alt=""
                 style="width:100%;height:120px;object-fit:cover;display:none;">
            <div id="{{ $foto['name'] }}_placeholder"
                 style="height:120px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/></svg>
              <span style="font-size:11px;color:#9ca3af;">Clic para subir</span>
            </div>
          </div>
          <input type="file" id="{{ $foto['name'] }}_input" name="{{ $foto['name'] }}" accept="image/*"
                 
                 style="display:none;"
                 onchange="previewFoto(this, '{{ $foto['name'] }}')">
        </div>
        @endforeach
      </div>
      {{-- Hidden inputs para fotos subidas desde mobile --}}
      <div id="mobilePhotoInputs"></div>

      {{-- QR para subir desde celu --}}
      <div style="margin-top:20px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:18px;display:flex;align-items:center;gap:20px;">
        <div>
          <img id="qrImg"
               src="https://api.qrserver.com/v1/create-qr-code/?size=110x110&data={{ urlencode(url('/mobile-upload/'.$uploadToken)) }}"
               style="width:110px;height:110px;border-radius:8px;">
        </div>
        <div style="flex:1;">
          <p style="font-size:13px;font-weight:700;color:#111;margin:0 0 4px;">📱 Subí fotos desde tu celular</p>
          <p style="font-size:12px;color:#6b7280;margin:0 0 10px;">Escaneá el QR con la cámara → sacá o elegí fotos → aparecen acá automáticamente.</p>
          <div id="mobileStatus" style="font-size:12px;color:#6b7280;">Esperando fotos del celular...</div>
        </div>
      </div>
    </div>

    <script>
    function previewFoto(input, name) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          var preview = document.getElementById(name + '_preview');
          var placeholder = document.getElementById(name + '_placeholder');
          preview.src = e.target.result;
          preview.style.display = 'block';
          placeholder.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
    </script>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:28px;margin-bottom:24px;">
      <h2 style="font-size:15px;font-weight:700;color:#111;margin:0 0 20px;padding-bottom:12px;border-bottom:1px solid #f3f4f6;">4. Confirmaciones obligatorias</h2>
      <div style="display:flex;flex-direction:column;gap:14px;">
        <label style="display:flex;align-items:flex-start;gap:12px;cursor:pointer;">
          <input type="checkbox" name="confirm_authentic" required style="margin-top:3px;width:16px;height:16px;flex-shrink:0;">
          <span style="font-size:13px;color:#374151;">Confirmo que el objeto es auténtico y de mi propiedad o tengo autorización para venderlo.</span>
        </label>
        <label style="display:flex;align-items:flex-start;gap:12px;cursor:pointer;">
          <input type="checkbox" name="confirm_description" required style="margin-top:3px;width:16px;height:16px;flex-shrink:0;">
          <span style="font-size:13px;color:#374151;">Confirmo que la descripción y las fotos son precisas y muestran el estado real del objeto.</span>
        </label>
        <label style="display:flex;align-items:flex-start;gap:12px;cursor:pointer;">
          <input type="checkbox" name="confirm_ship" required style="margin-top:3px;width:16px;height:16px;flex-shrink:0;">
          <span style="font-size:13px;color:#374151;">Me comprometo a enviar el objeto en 5 días hábiles tras la venta y a proporcionar número de seguimiento.</span>
        </label>
        <label style="display:flex;align-items:flex-start;gap:12px;cursor:pointer;">
          <input type="checkbox" name="confirm_terms" required style="margin-top:3px;width:16px;height:16px;flex-shrink:0;">
          <span style="font-size:13px;color:#374151;">He leído y acepto los <a href="/terminos" target="_blank" style="color:#1a56db;">Términos y condiciones</a> de RialBids.</span>
        </label>
      </div>
    </div>

    <div style="background:#fef3c7;border:1px solid #f59e0b;border-radius:8px;padding:14px 16px;margin-bottom:24px;">
      <p style="font-size:13px;color:#92400e;margin:0;">⚠️ Tu lote será revisado por nuestro equipo en 24-48h. Te notificaremos por email cuando esté aprobado.</p>
    </div>

    <input type="hidden" name="upload_token" value="{{ $uploadToken }}">

    <button type="submit" style="width:100%;padding:14px;background:#1a56db;color:#fff;border:none;border-radius:8px;font-size:15px;font-weight:600;cursor:pointer;">
      Enviar lote para revisión →
    </button>
  </form>

  <script>
  const UPLOAD_TOKEN = '{{ $uploadToken }}';
  let mobilePhotos = [];

  function syncMobilePhotos(photos) {
    const slots = ['image','image_2','image_3','image_4','image_5','image_6'];
    mobilePhotos = photos;

    // Actualizar hidden inputs
    const container = document.getElementById('mobilePhotoInputs');
    container.innerHTML = '';
    photos.forEach((p, i) => {
      const inp = document.createElement('input');
      inp.type = 'hidden';
      inp.name = 'mobile_photo_' + (i+1);
      inp.value = p;
      container.appendChild(inp);

      // Preview en los slots del desktop
      const slotName = slots[i];
      const preview = document.getElementById(slotName + '_preview');
      const placeholder = document.getElementById(slotName + '_placeholder');
      if (preview && placeholder) {
        preview.src = '/storage/' + p;
        preview.style.display = 'block';
        placeholder.style.display = 'none';
      }
    });

    // Actualizar status
    const status = document.getElementById('mobileStatus');
    if (photos.length === 0) {
      status.innerHTML = '<span style="color:#9ca3af;">Esperando fotos del celular...</span>';
    } else if (photos.length < 3) {
      status.innerHTML = '<span style="color:#d97706;">✓ ' + photos.length + ' foto(s) recibida(s) — faltan ' + (3 - photos.length) + ' más</span>';
    } else {
      status.innerHTML = '<span style="color:#16a34a;">✅ ' + photos.length + ' fotos listas</span>';
    }
  }

  // Polling cada 2 segundos
  setInterval(async () => {
    try {
      const res = await fetch('/mobile-upload/' + UPLOAD_TOKEN + '/status');
      const data = await res.json();
      if (JSON.stringify(data.photos) !== JSON.stringify(mobilePhotos)) {
        syncMobilePhotos(data.photos);
      }
    } catch(e) {}
  }, 2000);
  </script>
</div>
@endsection
