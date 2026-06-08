<x-guest-layout>
  <h2 style="font-size:20px;font-weight:700;color:#111827;margin-bottom:6px;">Crear cuenta</h2>
  <p style="font-size:13px;color:#6b7280;margin-bottom:24px;">Únete a RialBids y empezá a pujar</p>

  <a href="{{ route('auth.google') }}" style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;font-weight:500;color:#374151;background:#fff;text-decoration:none;margin-bottom:10px;font-family:'Inter',sans-serif;">
    <img src="https://www.google.com/favicon.ico" style="width:18px;height:18px;"> Continuar con Google
  </a>
  <a href="{{ route('auth.facebook') }}" style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:10px 14px;border:none;border-radius:8px;font-size:14px;font-weight:500;color:#fff;background:#1877f2;text-decoration:none;margin-bottom:16px;font-family:'Inter',sans-serif;">
    <img src="https://www.facebook.com/favicon.ico" style="width:18px;height:18px;"> Continuar con Facebook
  </a>
  <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;">
    <div style="flex:1;height:1px;background:#e5e7eb;"></div>
    <span style="font-size:12px;color:#9ca3af;">o con email</span>
    <div style="flex:1;height:1px;background:#e5e7eb;"></div>
  </div>

  <form method="POST" action="{{ route('register') }}">
    @csrf

    <div style="margin-bottom:16px;">
      <label style="font-size:13px;font-weight:500;color:#374151;display:block;margin-bottom:5px;">Nombre completo</label>
      <input style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;outline:none;font-family:'Inter',sans-serif;" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Tu nombre">
      @error('name')<p style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</p>@enderror
    </div>

    <div style="margin-bottom:16px;">
      <label style="font-size:13px;font-weight:500;color:#374151;display:block;margin-bottom:5px;">Email</label>
      <input style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;outline:none;font-family:'Inter',sans-serif;" type="email" name="email" value="{{ old('email') }}" required placeholder="tu@email.com">
      @error('email')<p style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</p>@enderror
    </div>

    <div style="margin-bottom:16px;">
      <label style="font-size:13px;font-weight:500;color:#374151;display:block;margin-bottom:5px;">Contraseña</label>
      <input style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;outline:none;font-family:'Inter',sans-serif;" type="password" name="password" required placeholder="Mínimo 8 caracteres">
      @error('password')<p style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</p>@enderror
    </div>

    <div style="margin-bottom:24px;">
      <label style="font-size:13px;font-weight:500;color:#374151;display:block;margin-bottom:5px;">Confirmar contraseña</label>
      <input style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;outline:none;font-family:'Inter',sans-serif;" type="password" name="password_confirmation" required placeholder="Repetí tu contraseña">
    </div>

    <div style="margin-bottom:16px;display:flex;align-items:flex-start;gap:10px;">
      <input type="checkbox" name="terms" id="terms" required style="margin-top:3px;flex-shrink:0;">
      <label for="terms" style="font-size:13px;color:#6b7280;line-height:1.5;">Soy mayor de 18 anos y acepto los <a href="/terminos" style="color:#1a56db;" target="_blank">terminos y condiciones</a> y la <a href="/privacidad" style="color:#1a56db;" target="_blank">politica de privacidad</a></label>
    </div>
    <button type="submit" style="width:100%;padding:11px;background:#1a56db;color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;">Crear cuenta</button>

    <p style="text-align:center;margin-top:16px;font-size:13px;color:#6b7280;">
      ¿Ya tenés cuenta? <a href="{{ route('login') }}" style="color:#1a56db;font-weight:500;">Iniciar sesión</a>
    </p>
  </form>
</x-guest-layout>
