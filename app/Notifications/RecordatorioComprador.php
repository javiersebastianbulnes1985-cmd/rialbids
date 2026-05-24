<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Auction;

class RecordatorioComprador extends Notification
{
    public function via($notifiable): array { return ['mail']; }

    public function toMail($notifiable): MailMessage
    {
        $subastas = Auction::where('status','active')->orderBy('end_time','asc')->take(2)->get();
        return (new MailMessage)
            ->subject($notifiable->locale === 'en' ? 'Auctions are closing' : 'Las subastas estan cerrando')
            ->view($notifiable->locale === 'en' ? 'emails.recordatorio_comprador_en' : 'emails.recordatorio_comprador', [
                'user' => $notifiable,
                'subastas' => $subastas,
            ]);
    }
}
