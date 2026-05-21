<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use App\Models\User;
use App\Notifications\NewsletterSemanal;
use App\Notifications\LotesFinalizanPronto;

class EnviarEmailsMarketing extends Command
{
    protected $signature = 'emails:marketing {tipo=semanal}';
    protected $description = 'Envia emails de marketing a los usuarios';

    public function handle()
    {
        $tipo = $this->argument('tipo');
        $usuarios = User::where('role', 'bidder')->get();

        if ($tipo === 'semanal') {
            $auctions = Auction::where('status', 'active')
                ->where('created_at', '>=', now()->subDays(7))
                ->orderBy('created_at', 'desc')
                ->get();
            if ($auctions->count() === 0) {
                $this->info('No hay lotes nuevos esta semana.');
                return;
            }
            foreach ($usuarios as $user) {
                $user->notify(new NewsletterSemanal($auctions));
            }
            $this->info('Newsletter enviado a ' . $usuarios->count() . ' usuarios.');
        }

        if ($tipo === 'finaliza') {
            $auctions = Auction::where('status', 'active')
                ->where('end_time', '<=', now()->addHours(48))
                ->where('end_time', '>', now())
                ->orderBy('end_time', 'asc')
                ->get();
            if ($auctions->count() === 0) {
                $this->info('No hay lotes finalizando pronto.');
                return;
            }
            foreach ($usuarios as $user) {
                $user->notify(new LotesFinalizanPronto($auctions));
            }
            $this->info('Email finaliza enviado a ' . $usuarios->count() . ' usuarios.');
        }
    }
}
