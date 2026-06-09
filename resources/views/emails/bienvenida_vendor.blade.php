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
    <h1 style="color:#c9a84c;font-size:22px;font-weight:700;margin:0 0 8px;font-family:Georgia,serif">Tu cuenta de vendedor esta lista</h1>
    <p style="color:#e8e4d9;font-size:15px;margin:0">Primer lote sin comision — publica hoy y cobras el 100%.</p>
  </td></tr>
  <tr><td style="padding:32px">
    <h2 style="font-size:20px;font-weight:700;color:#1a3a6b;margin:0 0 8px">Hola {{ $user->name }},</h2>
    <p style="font-size:15px;color:#374151;margin:0 0 24px">Ya podes empezar a vender en RialBids. Tu primer lote va sin comision.</p>
    <div style="background:#f5f3ef;border-left:4px solid #c9a84c;border-radius:0 4px 4px 0;padding:20px;margin-bottom:24px">
      <p style="font-size:14px;font-weight:700;color:#1a3a6b;margin:0 0 16px">Como empezar:</p>
      <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:12px">
        <tr>
          <td width="44" valign="top"><div style="background:#c9a84c;border-radius:50%;width:32px;height:32px;line-height:32px;text-align:center;font-size:14px;font-weight:700;color:#fff">1</div></td>
          <td style="padding-top:6px"><p style="font-size:14px;color:#374151;margin:0">Carga las fotos de tu producto</p></td>
        </tr>
      </table>
      <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:12px">
        <tr>
          <td width="44" valign="top"><div style="background:#c9a84c;border-radius:50%;width:32px;height:32px;line-height:32px;text-align:center;font-size:14px;font-weight:700;color:#fff">2</div></td>
          <td style="padding-top:6px"><p style="font-size:14px;color:#374151;margin:0">Completa los datos del lote</p></td>
        </tr>
      </table>
      <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
          <td width="44" valign="top"><div style="background:#c9a84c;border-radius:50%;width:32px;height:32px;line-height:32px;text-align:center;font-size:14px;font-weight:700;color:#fff">3</div></td>
          <td style="padding-top:6px"><p style="font-size:14px;color:#374151;margin:0">Envialo — nuestro equipo lo revisa y en menos de 24hs esta en vivo</p></td>
        </tr>
      </table>
    </div>
    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:32px">
      <tr><td align="center">
        <a href="{{ url('/vendor') }}" style="background:#1a3a6b;color:#fff;padding:14px 32px;border-radius:8px;font-size:15px;font-weight:700;text-decoration:none;display:inline-block">Subir mi primer lote ahora</a>
      </td></tr>
    </table>
    <div style="border-top:2px solid #c9a84c;padding-top:20px">
      <p style="font-size:13px;font-weight:700;color:#1a3a6b;margin:0 0 12px">Por que RialBids:</p>
      <p style="font-size:13px;color:#374151;margin:0 0 8px">&#10003; Compradores reales buscando piezas unicas</p>
      <p style="font-size:13px;color:#374151;margin:0 0 8px">&#10003; Cobras directo y seguro con Stripe</p>
      <p style="font-size:13px;color:#374151;margin:0 0 8px">&#10003; Sin suscripcion — pagas solo cuando vendes</p>
      <p style="font-size:13px;color:#374151;margin:0">&#10003; Te acompanamos en cada paso</p>
    </div>
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