<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewsletterSemanal extends Notification
{
    public function __construct(public $auctions) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $subjects = [
            'es' => 'Nuevos lotes esta semana en RialBids',
            'en' => 'New lots this week on RialBids',
            'de' => 'Neue Lose diese Woche bei RialBids',
            'pt' => 'Novos lotes esta semana na RialBids',
        ];
        $locale = in_array($notifiable->locale, ['en','de','pt']) ? $notifiable->locale : 'es';
        $view = $locale === 'es' ? 'emails.newsletter_semanal' : 'emails.newsletter_semanal_' . $locale;

        return (new MailMessage)
            ->subject($subjects[$locale])
            ->view($view, [
                'user' => $notifiable,
                'auctions' => $this->auctions,
            ]);
    }
}
