<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SuperadoEnPuja extends Notification
{
    public $auction;
    public $newAmount;

    public function __construct($auction, $newAmount)
    {
        $this->auction   = $auction;
        $this->newAmount = $newAmount;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Te superaron en una puja — ' . $this->auction->title)
            ->greeting('Hola ' . $notifiable->name . '!')
            ->line('Te superaron en la subasta: **' . $this->auction->title . '**')
            ->line('Nueva oferta: **€' . number_format($this->newAmount, 0, ',', '.') . '**')
            ->action('Volver a pujar', url('/auctions/' . $this->auction->id))
            ->line('¡No dejes escapar este lote!')
            ->salutation('El equipo de RialBids');
    }
}
