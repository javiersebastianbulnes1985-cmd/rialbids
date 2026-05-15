<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Auction;

class GanadorSubasta extends Notification
{
    public function __construct(public Auction $auction) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('¡Felicidades! Ganaste la subasta — ' . $this->auction->title)
            ->greeting('¡Hola ' . $notifiable->name . '!')
            ->line('Has ganado la subasta: **' . $this->auction->title . '**')
            ->line('Precio final: €' . number_format($this->auction->final_price, 0, ',', '.'))
            ->action('Ver subasta', url('/auctions/' . $this->auction->id))
            ->line('Nos pondremos en contacto contigo para coordinar el pago y la entrega.')
            ->salutation('El equipo de RialBids');
    }
}
