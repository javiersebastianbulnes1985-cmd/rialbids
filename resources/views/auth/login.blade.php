<x-guest-layout>
  <h2 style="font-size:20px;font-weight:700;color:#111827;margin-bottom:6px;">Iniciar sesión</h2>
  <p style="font-size:13px;color:#6b7280;margin-bottom:24px;">Bienvenido de vuelta a RialBids</p>

  @if(session('status'))
    <div style="background:#f0fdf4;border:1px solid #86efac;color:#166534;padding:10px;border-radius:8px;font-size:13px;margin-bottom:16px;">
      {{ session('status') }}
    </div>
  @endif

  <form method="POST" action="{{ route('login') }}">
    @csrf

    <div style="margin-bottom:16px;">
      <label style="font-size:13px;font-weight:500;color:#374151;display:block;margin-bottom:5px;">Email</label>
      <input style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;outline:none;font-family:'Inter',sans-serif;" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="tu@email.com">
      @error('email')<p style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</p>@enderror
    </div>

    <div style="margin-bottom:16px;">
      <div style="display:flex;justify-content:space-between;margin-bottom:5px;">
        <label style="font-size:13px;font-weight:500;color:#374151;">Contraseña</label>
        @if(Route::has('password.request'))
          <a href="{{ route('password.request') }}" style="font-size:13px;color:#1a56db;">¿Olvidaste tu contraseña?</a>
        @endif
      </div>
      <input style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;outline:none;font-family:'Inter',sans-serif;" type="password" name="password" required placeholder="Tu contraseña">
      @error('password')<p style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</p>@enderror
    </div>

    <div style="margin-bottom:20px;display:flex;align-items:center;gap:8px;">
      <input type="checkbox" name="remember" id="remember" style="width:16px;height:16px;accent-color:#1a56db;">
      <label for="remember" style="font-size:13px;color:#374151;">Recordarme</label>
    </div>

    <button type="submit" style="width:100%;padding:11px;background:#1a56db;color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;">Iniciar sesión</button>

    <p style="text-align:center;margin-top:16px;font-size:13px;color:#6b7280;">
      ¿No tenés cuenta? <a href="{{ route('register') }}" style="color:#1a56db;font-weight:500;">Registrarse</a>
    </p>
  </form>
</x-guest-layout>
