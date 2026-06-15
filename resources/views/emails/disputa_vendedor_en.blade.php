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
    <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">A buyer opened a dispute about your lot <strong>"{{ $titulo }}"</strong>.</p>
    <p style="font-size:14px;color:#374151;line-height:1.6;margin:0 0 6px"><strong>Reason:</strong> {{ $dispute->reason }}</p>
    @if($dispute->description)
    <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0 0 20px;padding:12px;background:#f9fafb;border-radius:8px">"{{ $dispute->description }}"</p>
    @endif
    <p style="font-size:15px;color:#374151;line-height:1.6;margin:0 0 16px">Before we make a decision, we want to hear your side. You have <strong>3 days</strong> to respond with your statement. If you don't respond, we'll resolve with the available information.</p>
    <table cellpadding="0" cellspacing="0" style="margin:8px 0 24px"><tr><td style="background:#1a3a6b;border-radius:8px"><a href="{{ url('/vendor') }}" style="display:inline-block;padding:12px 28px;color:#fff;font-size:15px;font-weight:600;text-decoration:none">Respond to the dispute</a></td></tr></table>
    <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0 0 24px">In the meantime, the payment for this transaction is held until the situation is resolved.</p>
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
