<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>
<body style="margin:0;padding:0;background:#f5f3ef;font-family:Arial,sans-serif">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f3ef;padding:40px 20px">
<tr><td align="center">
<table width="560" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:12px;overflow:hidden;max-width:560px;box-shadow:0 2px 8px rgba(0,0,0,0.06)">
  <tr><td style="background:#1a3a6b;padding:24px 32px;text-align:center">
    <span style="color:#fff;font-size:20px;font-weight:700;letter-spacing:0.5px">RialBids</span>
  </td></tr>
  <tr><td style="padding:32px">
    <p style="font-size:16px;color:#111827;margin:0 0 16px;font-weight:600">Hallo {{ $user->name }},</p>
    <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">Ein Kaeufer hat eine Reklamation zu Ihrem Los <strong>"{{ $titulo }}"</strong> eroeffnet.</p>
    <p style="font-size:14px;color:#374151;line-height:1.6;margin:0 0 6px"><strong>Grund:</strong> {{ $dispute->reason }}</p>
    @if($dispute->description)
    <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0 0 20px;padding:12px;background:#f9fafb;border-radius:8px">"{{ $dispute->description }}"</p>
    @endif
    <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">Bevor wir entscheiden, moechten wir Ihre Sicht hoeren. Sie haben <strong>3 Tage</strong>, um Ihre Stellungnahme abzugeben. Wenn Sie nicht antworten, entscheiden wir mit den verfuegbaren Informationen.</p>
    <table cellpadding="0" cellspacing="0" style="margin:8px 0 24px"><tr><td style="background:#1a3a6b;border-radius:8px"><a href="{{ url('/vendor') }}" style="display:inline-block;padding:12px 28px;color:#fff;font-size:15px;font-weight:600;text-decoration:none">Auf die Reklamation antworten</a></td></tr></table>
    <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0 0 24px">In der Zwischenzeit wird die Zahlung fuer diese Transaktion bis zur Klaerung zurueckgehalten.</p>
    <p style="font-size:15px;color:#111827;margin:0">Ihr RialBids-Team</p>
  </td></tr>
  <tr><td style="padding:16px 32px;border-top:1px solid #eee;text-align:center">
    <a href="{{ url('/') }}" style="color:#c9a84c;font-size:13px;text-decoration:none">rialbids.com</a>
  </td></tr>
</table>
</td></tr>
</table>
</body>
</html>
