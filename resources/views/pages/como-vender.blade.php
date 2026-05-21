@extends('layouts.app')
@section('title','Como vender en RialBids')
@section('content')
<div style="max-width:800px;margin:48px auto;padding:0 24px;">
<div style="text-align:center;margin-bottom:48px;">
<h1 style="font-size:36px;font-weight:700;color:#111;margin-bottom:16px;">Vende en RialBids</h1>
<p style="font-size:18px;color:#6b7280;">Tenes objetos que ya no usas? Vendelos en Europa.</p>
</div>
<div style="background:#f0fdf4;border:1px solid #86efac;border-radius:12px;padding:24px;margin-bottom:32px;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;">
<div><p style="font-size:16px;font-weight:700;color:#166534;margin:0;">Solo 9% + 3 euros de comision</p><p style="font-size:14px;color:#16a34a;margin:4px 0 0;">Sin cuotas. Solo pagas cuando vendes.</p></div>
<a href="/seller-request" style="background:#166534;color:#fff;padding:12px 24px;border-radius:6px;font-size:14px;font-weight:600;text-decoration:none;">Empezar a vender</a>
</div>
<div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:32px;margin-bottom:24px;">
<h2 style="font-size:20px;font-weight:700;color:#111;margin-bottom:24px;">Como funciona</h2>
<div style="display:flex;gap:20px;align-items:flex-start;margin-bottom:20px;"><div style="background:#111827;color:#fff;border-radius:50%;width:40px;height:40px;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">1</div><div><h3 style="font-size:15px;font-weight:700;color:#111;margin:0 0 6px;">Sube tu lote</h3><p style="font-size:14px;color:#6b7280;margin:0;">Registrate como vendedor y sube fotos y descripcion. Nuestro equipo lo revisa antes de publicarlo.</p></div></div>
<div style="display:flex;gap:20px;align-items:flex-start;margin-bottom:20px;"><div style="background:#111827;color:#fff;border-radius:50%;width:40px;height:40px;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">2</div><div><h3 style="font-size:15px;font-weight:700;color:#111;margin:0 0 6px;">Subasta de 7 dias</h3><p style="font-size:14px;color:#6b7280;margin:0;">Compradores de toda Europa compiten. El anti-sniping garantiza subastas justas.</p></div></div>
<div style="display:flex;gap:20px;align-items:flex-start;margin-bottom:20px;"><div style="background:#111827;color:#fff;border-radius:50%;width:40px;height:40px;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">3</div><div><h3 style="font-size:15px;font-weight:700;color:#111;margin:0 0 6px;">El comprador paga</h3><p style="font-size:14px;color:#6b7280;margin:0;">El ganador paga en 3 dias. El dinero queda en escrow hasta confirmar la entrega.</p></div></div>
<div style="display:flex;gap:20px;align-items:flex-start;"><div style="background:#16a34a;color:#fff;border-radius:50%;width:40px;height:40px;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">4</div><div><h3 style="font-size:15px;font-weight:700;color:#111;margin:0 0 6px;">Envias y cobras</h3><p style="font-size:14px;color:#6b7280;margin:0;">Envias en 10 dias. Al confirmar la entrega el pago llega a tu cuenta automaticamente.</p></div></div>
</div>
<div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:32px;margin-bottom:24px;">
<h2 style="font-size:20px;font-weight:700;color:#111;margin-bottom:16px;">Comisiones</h2>
<div style="background:#f9fafb;border-radius:8px;padding:20px;">
<div style="display:flex;justify-content:space-between;margin-bottom:10px;"><span style="font-size:14px;color:#6b7280;">Comision RialBids</span><span style="font-size:15px;font-weight:700;">9% del precio final</span></div>
<div style="display:flex;justify-content:space-between;margin-bottom:10px;"><span style="font-size:14px;color:#6b7280;">Tarifa fija</span><span style="font-size:15px;font-weight:700;">+ 3 euros</span></div>
<div style="border-top:1px solid #e5e7eb;padding-top:10px;display:flex;justify-content:space-between;"><span style="font-size:14px;font-weight:600;">Lote vendido en 100 euros</span><span style="font-size:15px;font-weight:700;color:#16a34a;">Cobras 88 euros</span></div>
</div></div>
<div style="background:#111827;border-radius:12px;padding:32px;text-align:center;">
<h2 style="font-size:20px;font-weight:700;color:#fff;margin-bottom:12px;">Listo para empezar?</h2>
<p style="font-size:14px;color:rgba(255,255,255,0.7);margin-bottom:20px;">Registrate y sube tu primer lote hoy.</p>
<a href="/seller-request" style="background:#1a56db;color:#fff;padding:14px 32px;border-radius:6px;font-size:15px;font-weight:600;text-decoration:none;">Empezar a vender en RialBids</a>
</div></div>
@endsection