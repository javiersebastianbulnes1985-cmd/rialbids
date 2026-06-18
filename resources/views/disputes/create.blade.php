@extends('layouts.app')

@section('content')
<div style="max-width:640px;margin:40px auto;padding:0 20px">

  <a href="{{ route('profile.index') }}" style="font-size:13px;color:#1a3a6b;text-decoration:none">&larr; Volver a mis compras</a>

  <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:28px;margin-top:16px">

    <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px">
      <span style="font-size:20px">&#128737;</span>
      <h1 style="font-size:20px;font-weight:700;color:#1a3a6b;margin:0">Abrir una disputa</h1>
    </div>
    <p style="font-size:14px;color:#6b7280;margin:0 0 24px">Lote: <strong style="color:#111827">{{ $auction->title }}</strong></p>

    @if(session('disputa_ok'))
      <div style="background:#f0fdf4;border:1px solid #86efac;border-radius:8px;padding:16px;margin-bottom:20px">
        <p style="font-size:14px;color:#166534;margin:0;font-weight:600">Tu disputa fue enviada.</p>
        <p style="font-size:13px;color:#166534;margin:6px 0 0">El equipo de RialBids la revisara y te contactara. El pago al vendedor queda retenido mientras tanto.</p>
      </div>
    @endif

    @if(isset($existing) && $existing && !session('disputa_ok'))
      <div style="background:#fff7ed;border:1px solid #fed7aa;border-radius:8px;padding:16px;margin-bottom:20px">
        <p style="font-size:14px;color:#9a3412;margin:0;font-weight:600">Ya tenes una disputa abierta para este lote.</p>
        <p style="font-size:13px;color:#9a3412;margin:6px 0 0">Estado: {{ ucfirst(str_replace('_',' ',$existing->status)) }}. Te contactaremos pronto.</p>
      </div>
    @else
      <div style="background:#eff6ff;border-left:4px solid #1a3a6b;border-radius:0 4px 4px 0;padding:14px;margin-bottom:24px">
        <p style="font-size:13px;color:#374151;margin:0">Tu pago esta retenido por RialBids. Si el objeto no llego o no es como se describio, contanos que paso y mediamos entre vos y el vendedor.</p>
      </div>

      @if($errors->any())
        <div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:8px;padding:14px;margin-bottom:20px">
          @foreach($errors->all() as $error)
            <p style="font-size:13px;color:#991b1b;margin:0">{{ $error }}</p>
          @endforeach
        </div>
      @endif

      <form method="POST" action="{{ route('disputes.store', $auction) }}" enctype="multipart/form-data">
        @csrf

        <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px">Motivo</label>
        <select name="reason" style="width:100%;padding:11px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;margin-bottom:20px;background:#fff">
          <option value="No llego el objeto">No llego el objeto</option>
          <option value="No es como se describio">No es como se describio</option>
          <option value="Llego danado">Llego danado</option>
          <option value="Otro">Otro</option>
        </select>

        <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px">Contanos que paso</label>
        <textarea name="description" rows="5" placeholder="Describi el problema con el mayor detalle posible..." style="width:100%;padding:11px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;margin-bottom:20px;resize:vertical;font-family:inherit"></textarea>

        <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px">Foto (opcional)</label>
        <input type="file" name="photo" accept="image/*" style="width:100%;padding:9px;border:1px solid #d1d5db;border-radius:8px;font-size:13px;margin-bottom:24px;background:#fff">

        <button type="submit" style="background:#1a3a6b;color:#fff;padding:13px 28px;border:none;border-radius:8px;font-size:15px;font-weight:700;cursor:pointer;width:100%">Enviar disputa</button>
      </form>
    @endif

  </div>
</div>
@endsection
