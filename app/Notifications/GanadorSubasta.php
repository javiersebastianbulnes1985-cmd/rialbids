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
            ->action('💳 Pagar ahora', url('/payment/' . $this->auction->id . '/checkout'))
            ->line('Tenés **3 días** para completar el pago.')
            ->line('Precio: €' . number_format($this->auction->final_price, 2, ',', '.') . ' + Comisión (9%+€3): €' . number_format($this->auction->final_price * 0.09 + 3, 2, ',', '.'))
            ->line('**Total a pagar: €' . number_format($this->auction->final_price + ($this->auction->final_price * 0.09 + 3), 2, ',', '.') . '**')
            ->line('Si no pagás en 3 días, la subasta puede ofrecerse al siguiente pujador.')
            ->salutation('El equipo de RialBids');
    }
}
