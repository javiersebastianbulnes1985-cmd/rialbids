<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\InvitacionPublicarVendor;

class InvitarVendedoresSinLotes extends Command
{
    protected $signature = 'vendedores:invitar';
    protected $description = 'Invita a publicar a vendedores reales sin lotes, registrados hace +3 dias, una sola vez';

    public function handle()
    {
        $vendedores = User::where('role', 'seller')
            ->whereDoesntHave('auctions')
            ->whereNull('invitacion_publicar_enviada_at')
            ->where('created_at', '<=', now()->subDays(3))
            ->where('email', 'not like', '%test%')
            ->where('email', 'not like', '%@test.%')
            ->where('email', 'not like', '%ejemplo%')
            ->where('email', 'not like', '%@rialbids.com')
            ->get();

        if ($vendedores->isEmpty()) {
            $this->info('No hay vendedores para invitar.');
            return;
        }

        $enviados = 0;
        foreach ($vendedores as $v) {
            try {
                $v->notify(new InvitacionPublicarVendor());
                $v->invitacion_publicar_enviada_at = now();
                $v->save();
                $this->info("Invitacion enviada a {$v->name} ({$v->email})");
                $enviados++;
            } catch (\Exception $e) {
                $this->error("Error con {$v->email}: " . $e->getMessage());
                \Log::error("vendedores:invitar error {$v->email}: " . $e->getMessage());
            }
        }

        $this->info("Total invitaciones enviadas: {$enviados}");
    }
}
