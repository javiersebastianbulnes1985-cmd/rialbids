<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use Illuminate\Support\Facades\Mail;

class PagosVencidos extends Command
{
    protected $signature = 'pagos:vencidos';
    protected $description = 'Detecta ganadores que no pagaron y bloquea sus cuentas';

    public function handle()
    {
        // 1. Recordatorio 24hs antes del vencimiento
        $porVencer = Auction::where('status', 'finished')
            ->whereNotNull('winner_id')
            ->where('updated_at', '<=', now()->subDays(2))
            ->where('updated_at', '>=', now()->subDays(2)->subHour())
            ->with('winner')
            ->get();

        foreach ($porVencer as $auction) {
            if (!$auction->winner) continue;
            Mail::send([], [], function($m) use ($auction) {
                $m->to($auction->winner->email)
                  ->subject('⚠️ Recordatorio: 24hs para pagar tu lote — ' . $auction->title)
                  ->html('<div style="font-family:sans-serif;max-width:600px;margin:0 auto;padding:32px">
                    <h2 style="color:#b45309">⚠️ Último aviso de pago</h2>
                    <p>Hola ' . e($auction->winner->name) . ',</p>
                    <p>Te quedan <strong>24 horas</strong> para pagar el lote <strong>' . e($auction->title) . '</strong> (€' . number_format($auction->current_price, 2) . ').</p>
                    <p>Si no pagás en ese plazo, tu cuenta quedará bloqueada para pujar.</p>
                    <a href="https://rialbids.com/perfil" style="background:#1a3a6b;color:#fff;padding:12px 24px;border-radius:8px;text-decoration:none;font-weight:700;display:inline-block;margin-top:16px">Pagar ahora →</a>
                    <p style="margin-top:24px;font-size:12px;color:#6b7280">RialBids — Subastas Online</p>
                  </div>');
            });
            $this->info("Recordatorio enviado: {$auction->winner->email} — #{$auction->id}");
        }

        // 2. Bloquear cuentas vencidas (más de 3 días sin pagar)
        $vencidas = Auction::where('status', 'finished')
            ->whereNotNull('winner_id')
            ->where('updated_at', '<=', now()->subDays(3))
            ->with('winner')
            ->get();

        foreach ($vencidas as $auction) {
            if (!$auction->winner) continue;

            // Incrementar contador de impagos
            $unpaid = $auction->winner->unpaid_count + 1;
            $auction->winner->update(['unpaid_count' => $unpaid]);

            // Cancelar subasta siempre
            $auction->update(['status' => 'cancelled']);

            if ($unpaid >= 2) {
                // Segunda falta: suspender cuenta
                $auction->winner->update(['is_active' => 0]);

                Mail::send([], [], function($m) use ($auction) {
                    $m->to('info@rialbids.com')
                      ->subject('Comprador suspendido por reincidencia — ' . $auction->title)
                      ->html('<div style="font-family:sans-serif;padding:24px"><h2>Comprador suspendido</h2><p><strong>' . e($auction->winner->name) . '</strong> (' . e($auction->winner->email) . ') — impagos: ' . $auction->winner->unpaid_count . '</p><p>Lote: ' . e($auction->title) . ' (#' . $auction->id . ')</p><a href="https://rialbids.com/admin" style="background:#1a3a6b;color:#fff;padding:12px 24px;border-radius:8px;text-decoration:none;font-weight:700;display:inline-block">Ver en admin</a></div>');
                });

                Mail::send([], [], function($m) use ($auction) {
                    $m->to($auction->winner->email)
                      ->subject('Tu cuenta en RialBids ha sido suspendida')
                      ->html('<div style="font-family:sans-serif;max-width:600px;margin:0 auto;padding:32px"><div style="background:#1a3a6b;padding:24px;border-radius:12px 12px 0 0;text-align:center"><h1 style="color:#c9a84c;margin:0">RialBids</h1></div><div style="padding:32px;border:1px solid #e5e7eb;border-top:none;border-radius:0 0 12px 12px"><h2 style="color:#dc2626">Cuenta suspendida</h2><p>Hola ' . e($auction->winner->name) . ',</p><p>Tu cuenta fue suspendida por no haber pagado por segunda vez un lote ganado en RialBids.</p><p>Para reactivarla contactanos a <a href="mailto:info@rialbids.com">info@rialbids.com</a>.</p><p style="font-size:12px;color:#9ca3af;margin-top:24px">RialBids — Subastas Online</p></div></div>');
                });
            } else {
                // Primera falta: aviso sin suspensión
                Mail::send([], [], function($m) use ($auction) {
                    $m->to('info@rialbids.com')
                      ->subject('Impago primer lote — ' . $auction->title)
                      ->html('<div style="font-family:sans-serif;padding:24px"><h2>Primer impago</h2><p><strong>' . e($auction->winner->name) . '</strong> (' . e($auction->winner->email) . ') no pagó el lote ' . e($auction->title) . ' (#' . $auction->id . '). Cuenta NO suspendida (primera vez).</p><a href="https://rialbids.com/admin" style="background:#1a3a6b;color:#fff;padding:12px 24px;border-radius:8px;text-decoration:none;font-weight:700;display:inline-block">Ver en admin</a></div>');
                });

                Mail::send([], [], function($m) use ($auction) {
                    $m->to($auction->winner->email)
                      ->subject('Tu lote en RialBids fue cancelado por falta de pago')
                      ->html('<div style="font-family:sans-serif;max-width:600px;margin:0 auto;padding:32px"><div style="background:#1a3a6b;padding:24px;border-radius:12px 12px 0 0;text-align:center"><h1 style="color:#c9a84c;margin:0">RialBids</h1></div><div style="padding:32px;border:1px solid #e5e7eb;border-top:none;border-radius:0 0 12px 12px"><h2 style="color:#b45309">Lote cancelado por falta de pago</h2><p>Hola ' . e($auction->winner->name) . ',</p><p>El lote <strong>' . e($auction->title) . '</strong> fue cancelado porque no fue pagado dentro del plazo de 3 días.</p><p>Por esta ocasión tu cuenta sigue activa. Te pedimos que en futuras subastas respetes los plazos de pago.</p><p>Si tuviste algún problema con el pago, contactanos a <a href="mailto:info@rialbids.com">info@rialbids.com</a>.</p><a href="https://rialbids.com" style="background:#1a3a6b;color:#c9a84c;padding:14px 28px;border-radius:8px;text-decoration:none;font-weight:700;display:inline-block;margin-top:16px">Explorar subastas →</a><p style="font-size:12px;color:#9ca3af;margin-top:24px">RialBids — Subastas Online</p></div></div>');
                });
            }

            $this->info("Bloqueado: {$auction->winner->email} — #{$auction->id}");
        }

        $this->info("Recordatorios: {$porVencer->count()} | Bloqueados: {$vencidas->count()}");
    }
}
