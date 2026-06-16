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
    <h1 style="color:#c9a84c;font-size:22px;font-weight:700;margin:0 0 8px;font-family:Georgia,serif">@if($locale=="es")Tu lote no fue aprobado@elseif($locale=="pt")O seu lote nao foi aprovado@elseif($locale=="de")Ihr Los wurde nicht genehmigt@else Your lot was not approved@endif</h1>
    <p style="color:#e8e4d9;font-size:15px;margin:0">@if($locale=="es")Podes corregirlo y volver a enviarlo.@elseif($locale=="pt")Pode corrigi-lo e resubmete-lo.@elseif($locale=="de")Sie koennen es korrigieren und erneut einreichen.@else You can fix it and resubmit.@endif</p>
  </td></tr>
  <tr><td style="padding:32px">
    <h2 style="font-size:20px;font-weight:700;color:#1a3a6b;margin:0 0 8px">Hola {{ $user->name }},</h2>
    <p style="font-size:15px;color:#374151;margin:0 0 24px">@if($locale=="es")Revisamos tu lote y no cumple con los requisitos de publicacion.@elseif($locale=="pt")Analisamos o seu lote e nao cumpre os requisitos de publicacao.@elseif($locale=="de")Wir haben Ihr Los geprueft und es erfuellt nicht die Anforderungen.@else We reviewed your lot and it does not meet our publishing requirements.@endif</p>
<div style="background:#f5f3ef;border-left:4px solid #1a3a6b;border-radius:0 4px 4px 0;padding:20px;margin-bottom:24px">
<p style="font-size:13px;font-weight:700;color:#1a3a6b;margin:0 0 8px;text-transform:uppercase;letter-spacing:1px">Lote</p>
<p style="font-size:15px;font-weight:700;color:#111827;margin:0">{{ $auction->title }}</p>
</div>
<div style="background:#fff8e1;border-left:4px solid #c9a84c;border-radius:0 4px 4px 0;padding:20px;margin-bottom:24px">
<p style="font-size:13px;font-weight:700;color:#1a3a6b;margin:0 0 8px;text-transform:uppercase;letter-spacing:1px">@if($locale=="de")Grund @elseif($locale=="en")Reason @else Motivo @endif</p>
<p style="font-size:15px;color:#374151;margin:0">{{ $auction->rejection_reason ?? "No especificado" }}</p>
</div>

    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px">
      <tr><td align="center">
        <a href="{{ url('/vendor/create') }}" style="background:#1a3a6b;color:#fff;padding:14px 32px;border-radius:8px;font-size:15px;font-weight:700;text-decoration:none;display:inline-block">
          @if($locale=="es")Subir nuevo lote @elseif($locale=="pt")Enviar novo lote @elseif($locale=="de")Neues Los einreichen @else Submit new lot @endif
        </a>
      </td></tr>
    <p style="font-size:12px;color:#9db4d4;margin:0;text-align:center">Consultas: <a href="mailto:info@rialbids.com" style="color:#c9a84c">info@rialbids.com</a></p>
    <p style="font-size:12px;color:#9db4d4;margin:4px 0 0;text-align:center">2026 RialBids. Todos los derechos reservados.</p>
  </td></tr>
</table>
</td></tr>
</table>
</body>
</html>