<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>
<body style="margin:0;padding:0;background:#f5f3ef;font-family:Arial,sans-serif">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f3ef;padding:40px 20px">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:12px;overflow:hidden;max-width:600px;box-shadow:0 2px 8px rgba(0,0,0,0.08)">
  <tr><td style="background:#fff;padding:20px 32px;text-align:center;border-bottom:1px solid #e5e7eb">
    <a href="{{ url("/") }}" style="text-decoration:none;display:inline-flex;align-items:center;gap:8px">
      <span style="background:#1a3a6b;color:#fff;font-size:16px;font-weight:800;width:32px;height:32px;line-height:32px;text-align:center;border-radius:6px;display:inline-block">R</span>
      <span style="color:#111827;font-size:20px;font-weight:700;font-family:Arial,sans-serif">RialBids</span>
    </a>
  </td></tr>
  <tr><td style="background:#1a3a6b;padding:28px 32px;text-align:center">
    <h1 style="color:#c9a84c;font-size:22px;font-weight:700;margin:0 0 8px;font-family:Georgia,serif">Pago confirmado</h1>
    <p style="color:#e8e4d9;font-size:15px;margin:0">Tu objeto esta en camino. Gracias por confiar en RialBids.</p>
  </td></tr>
  <tr><td style="padding:32px">
    <h2 style="font-size:20px;font-weight:700;color:#1a3a6b;margin:0 0 20px">Hola {{ $user->name }},</h2>
    <div style="background:#f5f3ef;border-left:4px solid #c9a84c;border-radius:0 4px 4px 0;padding:20px;margin-bottom:24px">
      <p style="font-size:13px;font-weight:700;color:#1a3a6b;margin:0 0 12px;text-transform:uppercase;letter-spacing:1px">Resumen de tu compra</p>
      <p style="font-size:15px;font-weight:700;color:#111827;margin:0 0 6px">{{ $auction->title }}</p>
      <p style="font-size:14px;color:#374151;margin:0 0 4px">Precio final: <strong>€{{ number_format($auction->final_price, 2, ",", ".") }}</strong></p>
      <p style="font-size:14px;color:#374151;margin:0">Lote: <strong>#{{ str_pad($auction->id, 4, "0", STR_PAD_LEFT) }}</strong></p>
    </div>
    <div style="background:#e8f5e9;border-left:4px solid #2e7d32;border-radius:0 4px 4px 0;padding:20px;margin-bottom:24px">
      <p style="font-size:14px;font-weight:700;color:#2e7d32;margin:0 0 8px">Que pasa ahora:</p>
      <p style="font-size:14px;color:#374151;margin:0 0 6px">1. El vendedor preparara tu objeto y lo enviara en los proximos 3 dias habiles.</p>
      <p style="font-size:14px;color:#374151;margin:0 0 6px">2. Recibiras un email con el numero de seguimiento cuando sea despachado.</p>
      <p style="font-size:14px;color:#374151;margin:0">3. Tu pago esta protegido por RialBids hasta que confirmes la recepcion.</p>
    </div>
    <div style="border-top:2px solid #c9a84c;padding-top:20px;margin-top:8px">
      <p style="font-size:13px;color:#374151;margin:0 0 8px">Compra protegida por RialBids — si hay algun problema, te ayudamos a resolverlo.</p>
      <p style="font-size:13px;color:#374151;margin:0">Consultas: <a href="mailto:info@rialbids.com" style="color:#1a3a6b;font-weight:700">info@rialbids.com</a></p>
    </div>
  </td></tr>
  <tr><td style="background:#1a3a6b;padding:20px 32px;border-top:3px solid #c9a84c">
    <p style="font-size:12px;color:#9db4d4;margin:0;text-align:center">2026 RialBids. Todos los derechos reservados.</p>
  </td></tr>
</table>
</td></tr>
</table>
</body>
</html>