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
    <p style="font-size:16px;color:#111827;margin:0 0 16px;font-weight:600">Hi {{ $user->name }},</p>
    @if($destinatario === 'comprador' && $favor === 'comprador')
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">We reviewed your dispute for the lot <strong>"{{ $titulo }}"</strong> and resolved it <strong style="color:#16a34a">in your favour</strong>.</p>
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">The refund has been processed. You'll see the amount credited to your payment method within the next few business days, depending on your bank.</p>
    @elseif($destinatario === 'comprador' && $favor === 'vendedor')
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">We carefully reviewed your dispute for the lot <strong>"{{ $titulo }}"</strong>.</p>
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">After evaluating the information from both parties, the dispute was resolved in favour of the seller. If you have additional information, you can reply to this email and we'll review it.</p>
    @elseif($destinatario === 'vendedor' && $favor === 'vendedor')
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">The dispute for the lot <strong>"{{ $titulo }}"</strong> was resolved <strong style="color:#16a34a">in your favour</strong>.</p>
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">The payment has been released to your account. You'll see it reflected according to your payout account's timing.</p>
    @else
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">The dispute for the lot <strong>"{{ $titulo }}"</strong> was resolved in favour of the buyer.</p>
      <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">The payment will not be released for this transaction. If you have questions about the decision, you can reply to this email.</p>
    @endif
    <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0 0 24px">Thank you for using RialBids and for your commitment to a safe and transparent buying and selling community.</p>
    <p style="font-size:15px;color:#111827;margin:0">The RialBids Team</p>
  </td></tr>
  <tr><td style="padding:16px 32px;border-top:1px solid #eee;text-align:center">
    <a href="{{ url('/') }}" style="color:#c9a84c;font-size:13px;text-decoration:none">rialbids.com</a>
  </td></tr>
</table>
</td></tr>
</table>
</body>
</html>
