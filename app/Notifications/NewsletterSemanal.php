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
        $msg = (new MailMessage)
            ->subject('Nuevos lotes esta semana en RialBids')
            ->greeting('Hola ' . $notifiable->name . ',')
            ->line('Esta semana tenemos ' . count($this->auctions) . ' lotes nuevos esperandote.');

        foreach ($this->auctions->take(6) as $auction) {
            $precio = '€' . number_format($auction->current_price ?? $auction->base_price ?? 0, 0, ',', '.');
            $msg->line('**' . $auction->title . '** — Puja actual: ' . $precio)
                ->action('Ver lote', url('/auctions/' . $auction->id));
        }

        return $msg
            ->line('Subastas cada semana — objetos unicos verificados en Europa.')
            ->salutation('El equipo de RialBids');
    }
}
