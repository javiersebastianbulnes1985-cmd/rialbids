<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BienvenidaVendor extends Notification
{
    public function via($notifiable): array { return ['mail']; }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Bienvenido a RialBids — Tu primer lote es GRATIS')
            ->view('emails.bienvenida_vendor', [
                'user' => $notifiable,
            ]);
    }
}
