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
    <h1 style="color:#c9a84c;font-size:22px;font-weight:700;margin:0 0 8px;font-family:Georgia,serif">Sie haben Ihr Los verkauft</h1>
    <p style="color:#e8e4d9;font-size:15px;margin:0">Ihr Stuck hat bei RialBids einen Kaufer gefunden.</p>
  </td></tr>
  <tr><td style="padding:32px">
    <h2 style="font-size:20px;font-weight:700;color:#1a3a6b;margin:0 0 8px">Hallo {{ $user->name }},</h2>
    <p style="font-size:15px;color:#374151;margin:0 0 24px">Gute Nachrichten: Ihr Los <strong>{{ $auction->title }}</strong> wurde verkauft. Hier ist die Aufstellung dessen, was Sie erhalten.</p>

    <div style="background:#f5f3ef;border-left:4px solid #c9a84c;border-radius:0 4px 4px 0;padding:20px;margin-bottom:24px">
      <table width="100%" cellpadding="0" cellspacing="0">
        <tr><td style="font-size:14px;color:#374151;padding:4px 0">Verkaufspreis</td><td style="font-size:14px;color:#374151;text-align:right;padding:4px 0">€{{ number_format($precio, 2, ',', '.') }}</td></tr>
        <tr><td style="font-size:14px;color:#374151;padding:4px 0">RialBids-Provision (9% + €3)</td><td style="font-size:14px;color:#374151;text-align:right;padding:4px 0">&minus;€{{ number_format($comision, 2, ',', '.') }}</td></tr>
        <tr><td colspan="2" style="border-top:1px solid #d6d1c4;padding-top:8px"></td></tr>
        <tr><td style="font-size:16px;font-weight:700;color:#1a3a6b;padding:4px 0">Sie erhalten</td><td style="font-size:16px;font-weight:700;color:#1a3a6b;text-align:right;padding:4px 0">€{{ number_format($neto, 2, ',', '.') }}</td></tr>
      </table>
    </div>

    <div style="background:#1a3a6b;border-radius:8px;padding:20px;margin-bottom:24px">
      <p style="font-size:14px;color:#fff;margin:0 0 6px"><strong style="color:#c9a84c">Wie es weitergeht:</strong></p>
      <p style="font-size:14px;color:#e8e4d9;margin:0">Wir benachrichtigen Sie, sobald der Kaufer die Zahlung abgeschlossen hat. Erst dann bereiten Sie den Versand vor — wir senden Ihnen die Lieferadresse. Das Geld wird nach Bestatigung des Erhalts auf Ihr Konto freigegeben.</p>
    </div>

    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px">
      <tr><td align="center">
        <a href="{{ url('/vendor') }}" style="background:#1a3a6b;color:#fff;padding:14px 32px;border-radius:8px;font-size:15px;font-weight:700;text-decoration:none;display:inline-block">Mein Verkauferbereich</a>
      </td></tr>
    </table>
  </td></tr>
  <tr><td style="background:#1a3a6b;padding:20px 32px;border-top:3px solid #c9a84c">
    <p style="font-size:12px;color:#9db4d4;margin:0;text-align:center">Fragen: <a href="mailto:info@rialbids.com" style="color:#c9a84c">info@rialbids.com</a></p>
    <p style="font-size:12px;color:#9db4d4;margin:4px 0 0;text-align:center">2026 RialBids. Alle Rechte vorbehalten.</p>
  </td></tr>
</table>
</td></tr>
</table>
</body>
</html>
