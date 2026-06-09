<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>
<body style="margin:0;padding:0;background:#f5f3ef;font-family:Arial,sans-serif">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f3ef;padding:40px 20px">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:12px;overflow:hidden;max-width:600px;box-shadow:0 2px 8px rgba(0,0,0,0.08)">
  <tr><td style="background:#fff;padding:20px 32px;text-align:center;border-bottom:1px solid #e5e7eb">
    <a href="{{ url('/') }}" style="text-decoration:none;display:inline-flex;align-items:center;gap:8px">
      <span style="background:#1a3a6b;color:#fff;font-size:16px;font-weight:800;width:32px;height:32px;line-height:32px;text-align:center;border-radius:6px;display:inline-block">R</span>
      <span style="color:#111827;font-size:20px;font-weight:700;font-family:Arial,sans-serif">RialBids</span>
    </a>
  </td></tr>
  <tr><td style="background:#1a3a6b;padding:28px 32px;text-align:center">
    <h1 style="color:#c9a84c;font-size:22px;font-weight:700;margin:0 0 8px;font-family:Georgia,serif">Bienvenido a RialBids</h1>
    <p style="color:#e8e4d9;font-size:15px;margin:0">Tu cuenta fue creada exitosamente.</p>
  </td></tr>
  <tr><td style="padding:32px">
    <h2 style="font-size:20px;font-weight:700;color:#1a3a6b;margin:0 0 8px">Hola {{ $user->name }},</h2>
    <p style="font-size:15px;color:#374151;margin:0 0 24px">Ya podes empezar a pujar en subastas unicas de joyas, antiguedades, arte y coleccionables de toda Europa.</p>
    <div style="background:#f5f3ef;border-left:4px solid #c9a84c;border-radius:0 4px 4px 0;padding:20px;margin-bottom:24px">
      <p style="font-size:14px;font-weight:700;color:#1a3a6b;margin:0 0 12px">Como funciona:</p>
      <p style="font-size:14px;color:#374151;margin:0 0 8px"><strong style="color:#c9a84c">1.</strong> Explora las subastas activas y encontra algo unico</p>
      <p style="font-size:14px;color:#374151;margin:0 0 8px"><strong style="color:#c9a84c">2.</strong> Hace tu puja — rapido, seguro, sin complicaciones</p>
      <p style="font-size:14px;color:#374151;margin:0"><strong style="color:#c9a84c">3.</strong> Si ganas, pagas con tarjeta y recibis tu objeto en casa</p>
    </div>
    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:32px">
      <tr><td align="center">
        <a href="{{ url('/') }}" style="background:#1a3a6b;color:#fff;padding:14px 32px;border-radius:8px;font-size:15px;font-weight:700;text-decoration:none;display:inline-block">Ver subastas en vivo</a>
      </td></tr>
    </table>
    @if($subastas->count() > 0)
    <p style="font-size:15px;font-weight:700;color:#1a3a6b;margin:0 0 16px;border-bottom:2px solid #c9a84c;padding-bottom:8px">Subastas cerrando pronto:</p>
    <table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        @foreach($subastas as $s)
        <td style="width:50%;padding:0 8px 16px;vertical-align:top">
          @if($s->image_path)
          <a href="{{ url('/auctions/'.$s->id) }}">
          <img src="{{ asset('storage/'.$s->image_path) }}" style="width:100%;height:160px;object-fit:cover;border-radius:8px;display:block;border:1px solid #e5e7eb">
          </a>
          @endif
          <p style="font-size:13px;font-weight:700;color:#1a3a6b;margin:8px 0 4px">{{ $s->title }}</p>
          <p style="font-size:14px;color:#16a34a;font-weight:700;margin:0 0 8px">EUR {{ number_format($s->current_price,0,',','.') }}</p>
          <a href="{{ url('/auctions/'.$s->id) }}" style="background:#1a3a6b;color:#fff;padding:6px 14px;border-radius:6px;font-size:12px;font-weight:600;text-decoration:none;display:inline-block">Pujar ahora</a>
        </td>
        @endforeach
      </tr>
    </table>
    @endif
  </td></tr>
  <tr><td style="background:#1a3a6b;padding:20px 32px;border-top:3px solid #c9a84c">
    <p style="font-size:12px;color:#9db4d4;margin:0;text-align:center">Consultas: <a href="mailto:info@rialbids.com" style="color:#c9a84c">info@rialbids.com</a></p>
    <p style="font-size:12px;color:#9db4d4;margin:4px 0 0;text-align:center">2026 RialBids. Todos los derechos reservados.</p>
  </td></tr>
</table>
</td></tr>
</table>
</body>
</html>