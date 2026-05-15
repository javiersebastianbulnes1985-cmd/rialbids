@extends('layouts.app')

@section('content')
<div style="max-width:700px;margin:40px auto;padding:0 20px;">

    <h1 style="font-size:24px;font-weight:700;color:#111;margin-bottom:24px;">Subir nuevo lote</h1>

    @if($errors->any())
        <div style="background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('vendor.store') }}" method="POST" enctype="multipart/form-data"
          style="background:#fff;padding:32px;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.1);">
        @csrf

        <div style="margin-bottom:20px;">
            <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Título *</label>
            <input type="text" name="title" value="{{ old('title') }}"
                   style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Descripción *</label>
            <textarea name="description" rows="5"
                      style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">{{ old('description') }}</textarea>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
            <div>
                <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Precio base (€) *</label>
                <input type="number" name="base_price" value="{{ old('base_price') }}" min="0" step="0.01"
                       style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
            </div>
            <div>
                <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Incremento mínimo (€)</label>
                <input type="number" name="min_increment" value="{{ old('min_increment', 10) }}" min="1"
                       style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
            <div>
                <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Precio de reserva (€)</label>
                <input type="number" name="reserve_price" value="{{ old('reserve_price') }}" min="0" step="0.01"
                       style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
            </div>
            <div>
                <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Fecha de cierre *</label>
                <input type="datetime-local" name="end_time" value="{{ old('end_time') }}"
                       style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
            </div>
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Categoría</label>
            <select name="lot_category"
                    style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
                <option value="general">General</option>
                <option value="arte">Arte</option>
                <option value="joyas">Joyas</option>
                <option value="relojes">Relojes</option>
                <option value="coleccionismo">Coleccionismo</option>
                <option value="electronica">Electrónica</option>
                <option value="muebles">Muebles y Antigüedades</option>
            </select>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:28px;">
            <div>
                <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Foto principal</label>
                <input type="file" name="image_" accept="image/*"
                       style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
            </div>
            <div>
                <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Foto adicional</label>
                <input type="file" name="image_2" accept="image/*"
                       style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
            </div>
        </div>

        <div style="background:#fef3c7;border:1px s
