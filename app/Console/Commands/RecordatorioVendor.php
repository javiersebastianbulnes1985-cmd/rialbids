<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Auction;

class RecordatorioVendor extends Command
{
    protected $signature = 'vendors:recordatorio';
    protected $description = 'Manda recordatorio a vendors sin lotes en 48hs';

    public function handle()
    {
        $vendors = User::where('role','seller')
            ->where('created_at','<=', now()->subHours(48))
            ->where('created_at','>=', now()->subHours(72))
            ->get();

        foreach($vendors as $vendor) {
            $tieneLotes = Auction::where('user_id', $vendor->id)->exists();
            if (!$tieneLotes) {
                $vendor->notify(new \App\Notifications\RecordatorioVendor());
                $this->info('Enviado a: ' . $vendor->email);
            }
        }
        $this->info('Procesados: ' . $vendors->count());
    }
}
