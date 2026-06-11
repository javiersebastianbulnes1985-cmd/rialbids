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
    <h1 style="color:#c9a84c;font-size:22px;font-weight:700;margin:0 0 8px;font-family:Georgia,serif">Neue Lose diese Woche</h1>
    <p style="color:#e8e4d9;font-size:15px;margin:0">Einzigartige geprüfte Stücke aus ganz Europa.</p>
  </td></tr>
  <tr><td style="padding:32px">
    <h2 style="font-size:20px;font-weight:700;color:#1a3a6b;margin:0 0 8px">Hola {{ $user->name }},</h2>
    <p style="font-size:15px;color:#374151;margin:0 0 24px">Diese Woche warten {{ count($auctions) }} neue Lose auf dich.</p>
    <table width="100%" cellpadding="0" cellspacing="0">
      @foreach($auctions->take(6)->chunk(2) as $row)
      <tr>
        @foreach($row as $a)
        <td style="width:50%;padding:0 {{ $loop->parent->first ? '' : '' }}{{ $loop->first ? '8px 12px 0 0' : '8px 0 0 12px' }};vertical-align:top">
          @if($a->image_path)
          <img src="{{ url('storage/'.$a->image_path) }}" style="width:100%;height:130px;object-fit:cover;border-radius:8px;display:block">
          @endif
          <p style="font-size:13px;font-weight:700;color:#1a3a6b;margin:8px 0 4px">{{ $a->title }}</p>
          <p style="font-size:13px;color:#16a34a;font-weight:700;margin:0 0 8px">€{{ number_format($a->current_price ?? $a->base_price ?? 0,0,',','.') }}</p>
          <a href="{{ url('/auctions/'.$a->id) }}" style="background:#1a3a6b;color:#fff;padding:6px 14px;border-radius:6px;font-size:12px;font-weight:600;text-decoration:none">Los ansehen</a>
        </td>
        @endforeach
        @if(count($row) == 1)<td style="width:50%"></td>@endif
      </tr>
      <tr><td colspan="2" style="height:16px"></td></tr>
      @endforeach
    </table>
    <p style="font-size:13px;color:#9ca3af;text-align:center;margin:16px 0 0">Fragen? <a href="mailto:info@rialbids.com" style="color:#c9a84c">info@rialbids.com</a></p>
  </td></tr>
  <tr><td style="background:#1a3a6b;padding:20px 32px;border-top:3px solid #c9a84c">
    <p style="font-size:12px;color:#9db4d4;margin:0;text-align:center">2026 RialBids. Alle Rechte vorbehalten.</p>
  </td></tr>
</table>
</td></tr>
</table>
</body>
</html>