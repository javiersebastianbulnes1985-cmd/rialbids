<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class LotesFinalizanPronto extends Notification
{
    public function __construct(public $auctions) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $subjects = [
            'es' => 'Lotes que finalizan pronto en RialBids',
            'en' => 'Lots ending soon on RialBids',
            'de' => 'Lose enden bald bei RialBids',
            'pt' => 'Lotes a terminar em breve na RialBids',
        ];
        $locale = in_array($notifiable->locale, ['en','de','pt']) ? $notifiable->locale : 'es';
        $view = $locale === 'es' ? 'emails.lotes_finalizan' : 'emails.lotes_finalizan_' . $locale;

        return (new MailMessage)
            ->subject($subjects[$locale])
            ->view($view, [
                'user' => $notifiable,
                'auctions' => $this->auctions,
            ]);
    }
}
