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
            ->subject($notifiable->locale === 'en' ? 'Welcome to RialBids — Your first lot is FREE' : 'Bienvenido a RialBids — Tu primer lote es GRATIS')
            ->view($notifiable->locale === 'en' ? 'emails.bienvenida_vendor_en' : 'emails.bienvenida_vendor', [
                'user' => $notifiable,
            ]);
    }
}
