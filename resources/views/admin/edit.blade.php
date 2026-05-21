<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Lote #{{ $auction->id }} — Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Inter',sans-serif;background:#f9fafb;color:#111827}
  </style>
</head>
<body>
<div style="max-width:860px;margin:40px auto;padding:0 20px;">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
    <h1 style="font-size:22px;font-weight:700;color:#111;">Editar lote #{{ $auction->id }}</h1>
    <a href="{{ route('admin.index') }}" style="color:#6b7280;font-size:13px;text-decoration:none;">← Volver al panel</a>
  </div>

  @if(session('success'))
  <div style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:20px;">
    {{ session('success') }}
  </div>
  @endif

  @if($errors->any())
  <div style="background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;">
    @foreach($errors->all() as $error)<p style="margin:2px 0;">{{ $error }}</p>@endforeach
  </div>
  @endif

  <form action="{{ route('admin.auctions.update', $auction->id) }}" method="POST" enctype="multipart/form-data"
        style="background:#fff;padding:32px;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.1);">
    @csrf

    <div style="margin-bottom:20px;">
      <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Título *</label>
      <input type="text" name="title" value="{{ $auction->title }}" required
             style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;">
    </div>

    <div style="margin-bottom:20px;">
      <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Descripción</label>
      <textarea name="description" rows="4"
                style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;">{{ $auction->description }}</textarea>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:20px;">
      <div>
        <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Precio base (€) *</label>
        <input type="number" name="base_price" value="{{ $auction->base_price }}" min="0" step="0.01" required
               style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;">
      </div>
      <div>
        <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Incremento mínimo (€)</label>
        <input type="number" name="min_increment" value="{{ $auction->min_increment ?? 10 }}" min="1"
               style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;">
      </div>
      <div>
        <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Precio de reserva (€)</label>
        <input type="number" name="reserve_price" value="{{ $auction->reserve_price }}" min="0" step="0.01"
               style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;">
      </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
      <div>
        <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Fecha de cierre * (hora UTC)</label>
        <input type="datetime-local" name="end_time" value="{{ \Carbon\Carbon::parse($auction->end_time)->format('Y-m-d\TH:i') }}" required
               style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;">
      </div>
      <div>
        <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Estado</label>
        <select name="status" style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;">
          <option value="active" {{ $auction->status==='active'?'selected':'' }}>Activo</option>
          <option value="pending" {{ $auction->status==='pending'?'selected':'' }}>Pendiente</option>
          <option value="finished" {{ $auction->status==='finished'?'selected':'' }}>Finalizado</option>
          <option value="shipped" {{ $auction->status==='shipped'?'selected':'' }}>Enviado</option>
          <option value="paid" {{ $auction->status==='paid'?'selected':'' }}>Pagado</option>
          <option value="cancelled" {{ $auction->status==='cancelled'?'selected':'' }}>Cancelado</option>
        </select>
      </div>
    </div>

    <div style="margin-bottom:20px;">
      <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Categoría</label>
      <select name="lot_category" style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;">
        @foreach(['general'=>'General','arte'=>'Arte','joyas'=>'Joyas','relojes'=>'Relojes','coleccionismo'=>'Coleccionismo','electronica'=>'Electrónica','muebles'=>'Antigüedades'] as $val=>$label)
          <option value="{{ $val }}" {{ $auction->lot_category===$val?'selected':'' }}>{{ $label }}</option>
        @endforeach
      </select>
    </div>

    <div style="margin-bottom:28px;">
      <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:10px;">Fotos</label>
      <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
        @foreach(['image_'=>['field'=>'image_path','label'=>'Principal'],'image_2'=>['field'=>'image_path_2','label'=>'Foto 2'],'image_3'=>['field'=>'image_path_3','label'=>'Foto 3']] as $input=>$info)
        <div>
          <label style="font-size:12px;font-weight:500;color:#6b7280;display:block;margin-bottom:6px;">{{ $info['label'] }}</label>
          <div style="width:100%;height:140px;border:2px dashed #e5e7eb;border-radius:8px;overflow:hidden;display:flex;align-items:center;justify-content:center;background:#f9fafb;margin-bottom:8px;">
            @if(!empty($auction->{$info['field']}))
              <img src="{{ asset('storage/'.$auction->{$info['field']}) }}" style="width:100%;height:100%;object-fit:cover;">
            @else
              <span style="font-size:12px;color:#9ca3af;">Sin foto</span>
            @endif
          </div>
          <input type="file" name="{{ $input }}" accept="image/*" style="width:100%;font-size:13px;">
        </div>
        @endforeach
      </div>
      <div style="margin-top:14px;">
        <label style="font-size:13px;font-weight:500;color:#374151;display:block;margin-bottom:5px;">Video YouTube <span style="color:#9ca3af;">opcional</span></label>
        <input type="url" name="video_url" value="{{ $auction->video_url }}"
               style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;"
               placeholder="https://www.youtube.com/watch?v=...">
      </div>
    </div>

    <div style="display:flex;gap:12px;">
      <button type="submit"
              style="flex:1;padding:12px;background:#2563eb;color:#fff;border:none;border-radius:8px;font-size:15px;font-weight:600;cursor:pointer;">

        <div style="margin-bottom:20px">
          <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Número de tracking</label>
          <input type="text" name="tracking_number" value="{{ $auction->tracking_number }}" placeholder="Ej: ES123456789CN" style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;">
          <div style="font-size:11px;color:#9ca3af;margin-top:4px">Número de seguimiento del envío (DHL, Correos, MRW, etc.)</div>
        </div>
        Guardar cambios
      </button>
      <a href="{{ route('admin.index') }}"
         style="flex:1;padding:12px;background:#f9fafb;color:#374151;border:1.5px solid #e5e7eb;border-radius:8px;font-size:15px;font-weight:600;text-align:center;text-decoration:none;">
        Cancelar
      </a>
    </div>
  </form>
</div>
</body>
</html>
