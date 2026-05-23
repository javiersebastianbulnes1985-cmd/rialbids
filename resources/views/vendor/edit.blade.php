@extends('layouts.app')
@section('content')
<div style="max-width:800px;margin:40px auto;padding:0 20px">
  <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px">
    <a href="{{ route('vendor.index') }}" style="color:#6b7280;text-decoration:none;font-size:13px">← Volver al panel</a>
  </div>
  <h1 style="font-size:20px;font-weight:700;color:#111827;margin:0 0 6px">Editar lote #{{ str_pad($auction->id,4,'0',STR_PAD_LEFT) }}</h1>
  <p style="font-size:13px;color:#f59e0b;margin:0 0 24px">⏳ En revisión — podés editar hasta que el admin lo apruebe.</p>

  @if($errors->any())
  <div style="background:#fef2f2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:13px">
    @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
  </div>
  @endif

  <form method="POST" action="{{ route('vendor.update',$auction->id) }}" enctype="multipart/form-data">
    @csrf
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:24px;margin-bottom:16px">
      <h2 style="font-size:14px;font-weight:700;color:#111;margin:0 0 16px">Información del objeto</h2>
      <div style="margin-bottom:16px">
        <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px">Título *</label>
        <input type="text" name="title" value="{{ old('title',$auction->title) }}" required
          style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box">
      </div>
      <div style="margin-bottom:16px">
        <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px">Descripción * <span style="font-weight:400;color:#9ca3af">(mín. 80 caracteres)</span></label>
        <textarea name="description" required rows="5"
          style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;resize:vertical">{{ old('description',$auction->description) }}</textarea>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px">
        <div>
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px">Precio base (€) *</label>
          <input type="number" name="base_price" value="{{ old('base_price',$auction->base_price) }}" min="20" required
            style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box">
        </div>
        <div>
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px">Precio reserva (€)</label>
          <input type="number" name="reserve_price" value="{{ old('reserve_price',$auction->reserve_price) }}" min="0"
            style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box">
        </div>
        <div>
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px">Condición *</label>
          <select name="condition" required style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box">
            <option value="excelente" {{ $auction->condition==='excelente'?'selected':'' }}>Excelente</option>
            <option value="muy_bueno" {{ $auction->condition==='muy_bueno'?'selected':'' }}>Muy bueno</option>
            <option value="bueno" {{ $auction->condition==='bueno'?'selected':'' }}>Bueno</option>
            <option value="regular" {{ $auction->condition==='regular'?'selected':'' }}>Regular</option>
          </select>
        </div>
      </div>
    </div>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:24px;margin-bottom:16px">
      <h2 style="font-size:14px;font-weight:700;color:#111;margin:0 0 16px">Fotos <span style="font-weight:400;font-size:12px;color:#9ca3af">Las fotos actuales se mantienen si no subís nuevas</span></h2>
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px">
        @php $fotoCampos = [['name'=>'image','field'=>'image_path','label'=>'Foto 1 — Principal'],['name'=>'image_2','field'=>'image_path_2','label'=>'Foto 2'],['name'=>'image_3','field'=>'image_path_3','label'=>'Foto 3'],['name'=>'image_4','field'=>'image_path_4','label'=>'Foto 4'],['name'=>'image_5','field'=>'image_path_5','label'=>'Foto 5'],['name'=>'image_6','field'=>'image_path_6','label'=>'Foto 6']]; @endphp
        @foreach($fotoCampos as $f)
        <div>
          <label style="display:block;font-size:12px;font-weight:600;color:#374151;margin-bottom:6px">{{ $f['label'] }}</label>
          @if(!empty($auction->{$f['field']}))
            <img src="{{ str_starts_with($auction->{$f['field']},'http') ? $auction->{$f['field']} : asset('storage/'.$auction->{$f['field']}) }}"
              style="width:100%;height:100px;object-fit:cover;border-radius:8px;border:1px solid #e5e7eb;margin-bottom:6px">
          @endif
          <input type="file" name="{{ $f['name'] }}" accept="image/*"
            style="width:100%;font-size:12px;padding:6px;border:1px solid #d1d5db;border-radius:6px;box-sizing:border-box">
        </div>
        @endforeach
      </div>
    </div>

    <div style="display:flex;gap:12px">
      <button type="submit" style="flex:1;padding:14px;background:#111827;color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:700;cursor:pointer">
        Guardar cambios
      </button>
      <a href="{{ route('vendor.index') }}" style="flex:1;padding:14px;background:#f3f4f6;color:#374151;border-radius:8px;font-size:14px;font-weight:600;text-align:center;text-decoration:none">
        Cancelar
      </a>
    </div>
  </form>
</div>
@endsection
