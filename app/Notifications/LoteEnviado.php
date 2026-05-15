<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Auction;

class LoteEnviado extends Notification
{
    public function __construct(public Auction $auction) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('📦 Tu lote ha sido enviado — RialBids')
            ->greeting("¡Hola {$notifiable->name}!")
            ->line("Tu lote **{$this->auction->title}** ha sido enviado.")
            ->line("Número de tracking: **{$this->auction->tracking_number}**")
            ->line("Una vez que lo recibas, confirmá la recepción en tu perfil para liberar el pago al vendedor.")
            ->action('Confirmar recepción', url('/perfil'))
            ->line('Si no confirmás en 7 días, el pago se liberará automáticamente.')
            ->salutation('El equipo de RialBids');
    }
}
