@extends('layouts.app')
@section('title','Admin — Crear Lote')
@push('scripts')
<script>
function previewImg(input,id){
  if(input.files&&input.files[0]){
    const r=new FileReader();
    r.onload=e=>{
      document.getElementById(id).style.backgroundImage='url('+e.target.result+')';
      document.getElementById(id).style.backgroundSize='cover';
      document.getElementById(id).style.backgroundPosition='center';
      document.getElementById(id).querySelector('span').style.display='none';
      document.getElementById(id).querySelector('svg').style.display='none';
    };
    r.readAsDataURL(input.files[0]);
  }
}
</script>
@endpush
@section('content')
<div style="max-width:860px;margin:40px auto;padding:0 20px;">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
    <h1 style="font-size:22px;font-weight:700;color:#111;">Crear nuevo lote</h1>
    <a href="{{ route('admin.index') }}" style="color:#6b7280;font-size:13px;text-decoration:none;">← Volver al panel</a>
  </div>

  @if($errors->any())
  <div style="background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;">
    @foreach($errors->all() as $error)<p style="margin:2px 0;">{{ $error }}</p>@endforeach
  </div>
  @endif

  <form action="{{ route('admin.auctions.store') }}" method="POST" enctype="multipart/form-data"
        style="background:#fff;padding:32px;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.1);">
    @csrf

    <div style="margin-bottom:20px;">
      <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Título *</label>
      <input type="text" name="title" value="{{ old('title') }}" required
             style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;box-sizing:border-box;">
    </div>

    <div style="margin-bottom:20px;">
      <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Descripción</label>
      <textarea name="description" rows="4"
                style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;box-sizing:border-box;">{{ old('description') }}</textarea>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:20px;">
      <div>
        <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Precio base (€) *</label>
        <input type="number" name="base_price" value="{{ old('base_price') }}" min="0" step="0.01" required
               style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;box-sizing:border-box;">
      </div>
      <div>
        <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Incremento mínimo (€)</label>
        <input type="number" name="min_increment" value="{{ old('min_increment',10) }}" min="1"
               style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;box-sizing:border-box;">
      </div>
      <div>
        <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Precio de reserva (€)</label>
        <input type="number" name="reserve_price" value="{{ old('reserve_price') }}" min="0" step="0.01"
               style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;box-sizing:border-box;">
      </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
      <div>
        <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Fecha de cierre * (hora UTC)</label>
        <input type="datetime-local" name="end_time" value="{{ old('end_time') }}" required
               style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;box-sizing:border-box;">
      </div>
      <div>
        <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Categoría</label>
        <select name="lot_category"
                style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;box-sizing:border-box;">
          <option value="general">General</option>
          <option value="arte">Arte</option>
          <option value="joyas">Joyas</option>
          <option value="relojes">Relojes</option>
          <option value="coleccionismo">Coleccionismo</option>
          <option value="electronica">Electrónica</option>
          <option value="muebles">Antigüedades</option>
        </select>
      </div>
    </div>

    <div style="margin-bottom:20px;">
      <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:10px;">Fotos</label>
      <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
        @foreach(['image_'=>'Principal','image_2'=>'Foto 2','image_3'=>'Foto 3'] as $name=>$label)
        <div>
          <label style="font-size:12px;font-weight:500;color:#6b7280;display:block;margin-bottom:6px;">{{ $label }}</label>
          <div id="prev_{{ $name }}" style="width:100%;height:140px;border:2px dashed #e5e7eb;border-radius:8px;display:flex;flex-direction:column;align-items:center;justify-content:center;background:#f9fafb;margin-bottom:8px;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5">
              <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
            </svg>
            <span style="font-size:11px;color:#9ca3af;margin-top:4px;">Preview</span>
          </div>
          <input type="file" name="{{ $name }}" accept="image/*"
                 style="width:100%;font-size:13px;"
                 onchange="previewImg(this,'prev_{{ $name }}')">
        </div>
        @endforeach
      </div>

      <div style="margin-top:14px;">
        <label style="font-size:13px;font-weight:500;color:#374151;display:block;margin-bottom:5px;">Video YouTube <span style="color:#9ca3af;font-weight:400;">opcional</span></label>
        <input type="url" name="video_url" value="{{ old('video_url') }}"
               style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;box-sizing:border-box;"
               placeholder="https://www.youtube.com/watch?v=...">
      </div>
    </div>

    <div style="display:flex;gap:12px;">
      <button type="submit" name="status" value="active"
              style="flex:1;padding:12px;background:#2563eb;color:#fff;border:none;border-radius:8px;font-size:15px;font-weight:600;cursor:pointer;">
        Publicar lote activo
      </button>
      <button type="submit" name="status" value="pending"
              style="flex:1;padding:12px;background:#f9fafb;color:#374151;border:1.5px solid #e5e7eb;border-radius:8px;font-size:15px;font-weight:600;cursor:pointer;">
        Guardar como borrador
      </button>
    </div>
  </form>
</div>
@endsection
