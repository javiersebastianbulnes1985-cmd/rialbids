<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Bid;

class RecordatorioComprador extends Command
{
    protected $signature = 'compradores:recordatorio';
    protected $description = 'Manda recordatorio a compradores sin pujas en 24hs';

    public function handle()
    {
        $compradores = User::where('role','bidder')
            ->where('created_at','<=', now()->subHours(24))
            ->where('created_at','>=', now()->subHours(48))
            ->get();

        foreach($compradores as $comprador) {
            $tienePujas = Bid::where('user_id', $comprador->id)->exists();
            if (!$tienePujas) {
                $comprador->notify(new \App\Notifications\RecordatorioComprador());
                $this->info('Enviado a: ' . $comprador->email);
            }
        }
        $this->info('Procesados: ' . $compradores->count());
    }
}
