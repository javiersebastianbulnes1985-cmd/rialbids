<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class RecordatorioVendor extends Notification
{
    public function via($notifiable): array { return ['mail']; }

    public function toMail($notifiable): MailMessage
    {
        $subjects = [
            'es' => 'Tu primer lote te esta esperando',
            'en' => 'Your first lot is waiting for you',
            'de' => 'Dein erstes Los wartet auf dich',
            'pt' => 'O teu primeiro lote está à tua espera',
        ];
        $locale = in_array($notifiable->locale, ['en','de','pt']) ? $notifiable->locale : 'es';
        $view = $locale === 'es' ? 'emails.recordatorio_vendor' : 'emails.recordatorio_vendor_' . $locale;

        return (new MailMessage)
            ->subject($subjects[$locale])
            ->view($view, ['user' => $notifiable]);
    }
}
