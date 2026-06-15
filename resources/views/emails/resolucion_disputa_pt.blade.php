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
    <p style="font-size:16px;color:#111827;margin:0 0 16px;font-weight:600">Ola {{ $user->name }},</p>
    @if($destinatario === 'comprador' && $favor === 'comprador')
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">Analisamos a sua disputa do lote <strong>"{{ $titulo }}"</strong> e resolvemo-la <strong style="color:#16a34a">a seu favor</strong>.</p>
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">O reembolso foi processado. Vera o valor creditado no seu metodo de pagamento nos proximos dias uteis, conforme o seu banco.</p>
    @elseif($destinatario === 'comprador' && $favor === 'vendedor')
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">Analisamos com atencao a sua disputa do lote <strong>"{{ $titulo }}"</strong>.</p>
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">Apos avaliar a informacao de ambas as partes, a disputa foi resolvida a favor do vendedor. Se tiver informacao adicional, pode responder a este email e iremos analisa-la.</p>
    @elseif($destinatario === 'vendedor' && $favor === 'vendedor')
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">A disputa do lote <strong>"{{ $titulo }}"</strong> foi resolvida <strong style="color:#16a34a">a seu favor</strong>.</p>
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">O pagamento foi liberado para a sua conta. Vera o valor refletido conforme os tempos da sua conta de cobranca.</p>
    @else
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">A disputa do lote <strong>"{{ $titulo }}"</strong> foi resolvida a favor do comprador.</p>
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">O pagamento nao sera liberado para esta operacao. Se tiver duvidas sobre a decisao, pode responder a este email.</p>
    @endif
    <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0 0 24px">Obrigado por usar a RialBids e pelo seu compromisso com uma comunidade de compra e venda segura e transparente.</p>
    <p style="font-size:15px;color:#111827;margin:0">Equipa RialBids</p>
  </td></tr>
  <tr><td style="padding:16px 32px;border-top:1px solid #eee;text-align:center">
    <a href="{{ url('/') }}" style="color:#c9a84c;font-size:13px;text-decoration:none">rialbids.com</a>
  </td></tr>
</table>
</td></tr>
</table>
</body>
</html>
