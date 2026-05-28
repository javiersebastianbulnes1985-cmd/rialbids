<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="margin:0;padding:0;background:#f3f4f6;font-family:Arial,sans-serif">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f3f4f6;padding:40px 20px">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:12px;overflow:hidden;max-width:600px">

  {{-- HEADER --}}
  <tr><td style="padding:32px 32px 16px;text-align:center;border-bottom:1px solid #e5e7eb">
    <a href="{{ url("/vendor") }}" style="text-decoration:none">
      <span style="color:#111827;font-size:28px;font-weight:800;font-family:Georgia,serif;letter-spacing:-1px">RialBids</span>
    </a>
  </td></tr>

  {{-- BODY --}}
  <tr><td style="padding:32px">
    <h2 style="font-size:22px;font-weight:700;color:#111;margin:0 0 8px">Hello {{ $user->name }}!</h2>
    <p style="font-size:15px;color:#374151;margin:0 0 24px">Your seller account is ready. Your first lot with no commission — publish today and keep 100% of your sale.</p>

    <div style="background:#f9fafb;border-radius:8px;padding:20px;margin-bottom:24px">
      <p style="font-size:14px;font-weight:700;color:#111;margin:0 0 12px">How it works in 3 steps:</p>
      <p style="font-size:14px;color:#374151;margin:0 0 8px"><strong>1.</strong> Browse active auctions and find something unique</p>
      <p style="font-size:14px;color:#374151;margin:0 0 8px"><strong>2.</strong> Place your bid — fast, secure, no complications</p>
      <p style="font-size:14px;color:#374151;margin:0"><strong>3.</strong> If you win, pay by card and receive your item at home</p>
    </div>

    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px">
      <tr>
        <td align="center">
          <a href="{{ url("/vendor") }}" style="background:#1a56db;color:#fff;padding:12px 28px;border-radius:8px;font-size:15px;font-weight:700;text-decoration:none;display:inline-block">Upload my first lot</a>
        </td>
      </tr>
    </table>

    @if($subastas->count() > 0)
    <p style="font-size:15px;font-weight:700;color:#111;margin:0 0 16px">Auctions closing soon:</p>
    <table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        @foreach($subastas as $s)
        <td style="width:50%;padding:0 {{ $loop->first ? '8px 0 0' : '0 0 0 8px' }};vertical-align:top">
          @if($s->image_path)
          <img src="{{ url('storage/'.$s->image_path) }}" style="width:100%;height:150px;object-fit:cover;border-radius:8px;display:block">
          @endif
          <p style="font-size:13px;font-weight:700;color:#111;margin:8px 0 4px">{{ $s->title }}</p>
          <p style="font-size:13px;color:#1a56db;margin:0 0 8px">€{{ number_format($s->current_price,0,',','.') }}</p>
          <a href="{{ url('/auctions/'.$s->id) }}" style="background:#1a56db;color:#fff;padding:6px 14px;border-radius:6px;font-size:12px;font-weight:600;text-decoration:none">Bid now</a>
        </td>
        @endforeach
      </tr>
    </table>
    @endif

  </td></tr>

  {{-- FOOTER --}}
  <tr><td style="background:#f9fafb;padding:20px 32px;border-top:1px solid #e5e7eb">
    <p style="font-size:12px;color:#9ca3af;margin:0;text-align:center">Questions? Write to us at <a href="mailto:info@rialbids.com" style="color:#1a56db">info@rialbids.com</a></p>
    <p style="font-size:12px;color:#9ca3af;margin:4px 0 0;text-align:center">© 2026 RialBids. All rights reserved.</p>
  </td></tr>

</table>
</td></tr>
</table>
</body>
</html>
