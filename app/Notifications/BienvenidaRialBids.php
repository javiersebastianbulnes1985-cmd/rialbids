<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Auction;

class BienvenidaRialBids extends Notification
{
    public function via($notifiable): array { return ['mail']; }

    public function toMail($notifiable): MailMessage
    {
        $subastas = Auction::where('status','active')->orderBy('end_time','asc')->take(2)->get();
        return (new MailMessage)
            ->subject($notifiable->locale === 'en' ? 'Welcome to RialBids — Start bidding today' : 'Bienvenido a RialBids — Empeza a pujar hoy')
            ->view($notifiable->locale === 'en' ? 'emails.bienvenida_comprador_en' : 'emails.bienvenida_comprador', [
                'user' => $notifiable,
                'subastas' => $subastas,
            ]);
    }
}
