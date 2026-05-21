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
        $msg = (new MailMessage)
            ->subject('Lotes que finalizan pronto en RialBids')
            ->greeting('Hola ' . $notifiable->name . ',')
            ->line('Estos lotes cierran en menos de 48 horas. No te los pierdas.');

        foreach ($this->auctions->take(6) as $auction) {
            $precio = '€' . number_format($auction->current_price ?? $auction->base_price ?? 0, 0, ',', '.');
            $msg->line('**' . $auction->title . '** — Puja actual: ' . $precio)
                ->action('Pujar ahora', url('/auctions/' . $auction->id));
        }

        return $msg
            ->line('Recordá que las pujas son vinculantes.')
            ->salutation('El equipo de RialBids');
    }
}
