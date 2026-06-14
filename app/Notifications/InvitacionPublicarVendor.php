<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class InvitacionPublicarVendor extends Notification
{
    public function via($notifiable): array { return ['mail']; }

    public function toMail($notifiable): MailMessage
    {
        $subjects = [
            'es' => 'Te ayudo a publicar tu primer lote en RialBids?',
            'en' => 'Can I help you publish your first lot on RialBids?',
            'de' => 'Kann ich Ihnen helfen, Ihr erstes Los bei RialBids einzustellen?',
            'pt' => 'Ajudo-o a publicar o seu primeiro lote na RialBids?',
        ];
        $locale = in_array($notifiable->locale, ['en','de','pt']) ? $notifiable->locale : 'es';
        $view = $locale === 'es' ? 'emails.invitacion_publicar' : 'emails.invitacion_publicar_' . $locale;

        return (new MailMessage)
            ->subject($subjects[$locale])
            ->view($view, ['user' => $notifiable]);
    }
}
