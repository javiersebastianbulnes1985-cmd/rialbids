<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class RecordatorioVendor extends Notification
{
    public function via($notifiable): array { return ['mail']; }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($notifiable->locale === 'en' ? 'Your first lot is waiting for you' : 'Tu primer lote te esta esperando')
            ->view($notifiable->locale === 'en' ? 'emails.recordatorio_vendor_en' : 'emails.recordatorio_vendor', ['user' => $notifiable]);
    }
}
