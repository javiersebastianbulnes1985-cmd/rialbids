@extends('layouts.app')
@section('title','Vender en RialBids')
@section('content')
<div style="max-width:600px;margin:48px auto;padding:0 24px;">

  <h1 style="font-size:28px;font-weight:700;color:#111;margin-bottom:8px;text-align:center;">Vendé en RialBids</h1>
  <p style="font-size:15px;color:#6b7280;margin-bottom:32px;text-align:center;">Subastá tus objetos al mejor precio en Europa. Gratis. Sin compromiso.</p>

  <div style="background:#fff;border:2px solid #1a56db;border-radius:12px;padding:32px;">
    <h2 style="font-size:20px;font-weight:700;color:#111;margin-bottom:4px;">Activá tu cuenta de vendedor</h2>
    <p style="font-size:14px;color:#6b7280;margin-bottom:24px;">Tu cuenta se activa al instante.</p>

    <a href="{{ route('auth.google') }}" style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;font-weight:500;color:#374151;background:#fff;text-decoration:none;margin-bottom:10px;box-sizing:border-box;">
      <img src="https://www.google.com/favicon.ico" style="width:18px;height:18px;"> Registrarme con Google
    </a>
    <a href="{{ route('auth.facebook') }}" style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:10px 14px;border:none;border-radius:8px;font-size:14px;font-weight:500;color:#fff;background:#1877f2;text-decoration:none;margin-bottom:20px;box-sizing:border-box;">
      <img src="https://www.facebook.com/favicon.ico" style="width:18px;height:18px;"> Registrarme con Facebook
    </a>

    <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
      <div style="flex:1;height:1px;background:#e5e7eb;"></div>
      <span style="font-size:12px;color:#9ca3af;">o completá el formulario</span>
      <div style="flex:1;height:1px;background:#e5e7eb;"></div>
    </div>

    @if($errors->any())
      <div style="background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;">
        @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
      </div>
    @endif

    <form action="/seller-request" method="POST">
      @csrf

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
        <div>
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Nombre completo *</label>
          <input type="text" name="name" value="{{ old('name') }}" required
                 style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
        </div>
        <div>
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Email *</label>
          <input type="email" name="email" value="{{ old('email') }}" required
                 style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
        </div>
      </div>

      <div style="margin-bottom:16px;">
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
        <div>
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Contrasena *</label>
          <input type="password" name="password" required minlength="8" style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
        </div>
        <div>
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Repetir contrasena *</label>
          <input type="password" name="password_confirmation" required minlength="8" style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
        </div>
      </div>
      <div style="margin-bottom:16px;">
        <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">País *</label>
        <select name="country" required
                style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
          <option value="">Seleccioná tu país</option>
          <option value="España">España</option>
          <option value="Francia">Francia</option>
          <option value="Italia">Italia</option>
          <option value="Alemania">Alemania</option>
          <option value="Portugal">Portugal</option>
          <option value="Países Bajos">Países Bajos</option>
          <option value="Bélgica">Bélgica</option>
          <option value="Suecia">Suecia</option>
          <option value="Polonia">Polonia</option>
          <option value="Austria">Austria</option>
          <option value="Suiza">Suiza</option>
          <option value="Dinamarca">Dinamarca</option>
          <option value="Noruega">Noruega</option>
          <option value="Finlandia">Finlandia</option>
          <option value="Grecia">Grecia</option>
          <option value="Otro">Otro</option>
        </select>
      </div>

      <div style="margin-bottom:24px;">
        <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">¿Qué querés vender? *</label>
        <textarea name="what_sells" rows="3" required
                  style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">{{ old('what_sells') }}</textarea>
        <p style="font-size:12px;color:#9ca3af;margin-top:4px;">Describí brevemente el tipo de objetos que querés subastar.</p>
      </div>

      <button type="submit" style="width:100%;padding:14px;background:#1a56db;color:#fff;border:none;border-radius:8px;font-size:15px;font-weight:600;cursor:pointer;">
        Activar mi cuenta de vendedor →
      </button>
    </form>
  </div>

</div>
@endsection
