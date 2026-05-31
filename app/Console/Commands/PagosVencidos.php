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

            // Bloquear cuenta
            $auction->winner->update(['is_active' => 0]);

            // Cancelar subasta
            $auction->update(['status' => 'cancelled']);

            // Notificar al admin
            Mail::send([], [], function($m) use ($auction) {
                $m->to('info@rialbids.com')
                  ->subject('🚨 Comprador bloqueado por no pago — ' . $auction->title)
                  ->html('<div style="font-family:sans-serif;padding:24px">
                    <h2>🚨 Comprador bloqueado</h2>
                    <p><strong>Comprador:</strong> ' . e($auction->winner->name) . ' (' . e($auction->winner->email) . ')</p>
                    <p><strong>Lote:</strong> ' . e($auction->title) . ' (#' . $auction->id . ')</p>
                    <p><strong>Monto:</strong> €' . number_format($auction->current_price, 2) . '</p>
                    <p>La cuenta fue bloqueada. El lote quedó cancelado para resubasta.</p>
                    <a href="https://rialbids.com/admin" style="background:#1a3a6b;color:#fff;padding:12px 24px;border-radius:8px;text-decoration:none;font-weight:700;display:inline-block">Ver en admin →</a>
                  </div>');
            });

            // Notificar al comprador
            Mail::send([], [], function($m) use ($auction) {
                $m->to($auction->winner->email)
                  ->subject('Tu cuenta en RialBids ha sido suspendida')
                  ->html('<div style="font-family:sans-serif;max-width:600px;margin:0 auto;padding:32px">
                    <h2 style="color:#dc2626">Cuenta suspendida</h2>
                    <p>Hola ' . e($auction->winner->name) . ',</p>
                    <p>Tu cuenta fue suspendida por no haber pagado el lote <strong>' . e($auction->title) . '</strong> dentro del plazo de 3 días.</p>
                    <p>Para reactivarla, contactanos a <a href="mailto:info@rialbids.com">info@rialbids.com</a>.</p>
                    <p style="margin-top:24px;font-size:12px;color:#6b7280">RialBids — Subastas Online</p>
                  </div>');
            });

            $this->info("Bloqueado: {$auction->winner->email} — #{$auction->id}");
        }

        $this->info("Recordatorios: {$porVencer->count()} | Bloqueados: {$vencidas->count()}");
    }
}
