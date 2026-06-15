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
    @if($destinatario === 'comprador' && $favor === 'comprador')
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">Wir haben Ihre Reklamation zum Los <strong>"{{ $titulo }}"</strong> geprueft und <strong style="color:#16a34a">zu Ihren Gunsten</strong> entschieden.</p>
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">Die Rueckerstattung wurde veranlasst. Der Betrag wird je nach Bank in den naechsten Werktagen Ihrem Zahlungsmittel gutgeschrieben.</p>
    @elseif($destinatario === 'comprador' && $favor === 'vendedor')
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">Wir haben Ihre Reklamation zum Los <strong>"{{ $titulo }}"</strong> sorgfaeltig geprueft.</p>
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">Nach Pruefung der Informationen beider Parteien wurde die Reklamation zugunsten des Verkaeufers entschieden. Falls Sie weitere Informationen haben, koennen Sie auf diese E-Mail antworten.</p>
    @elseif($destinatario === 'vendedor' && $favor === 'vendedor')
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">Die Reklamation zum Los <strong>"{{ $titulo }}"</strong> wurde <strong style="color:#16a34a">zu Ihren Gunsten</strong> entschieden.</p>
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">Die Zahlung wurde auf Ihr Konto freigegeben. Sie sehen den Betrag entsprechend den Zeiten Ihres Auszahlungskontos.</p>
    @else
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">Die Reklamation zum Los <strong>"{{ $titulo }}"</strong> wurde zugunsten des Kaeufers entschieden.</p>
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">Die Zahlung wird fuer diese Transaktion nicht freigegeben. Bei Fragen zur Entscheidung koennen Sie auf diese E-Mail antworten.</p>
    @endif
    <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0 0 24px">Vielen Dank, dass Sie RialBids nutzen und sich fuer eine sichere und transparente Kauf- und Verkaufsgemeinschaft einsetzen.</p>
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
