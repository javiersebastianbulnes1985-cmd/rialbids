<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Auction;

class LoteCancelado extends Notification
{
    public function __construct(public Auction $auction, public string $motivo) {}
    public function via($notifiable): array { return ['mail']; }
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('⚠️ Lote cancelado — ' . $this->auction->title)
            ->greeting('Hola ' . $notifiable->name)
            ->line('El siguiente lote ha sido cancelado por el equipo de RialBids:')
            ->line('**' . $this->auction->title . '**')
            ->line('Motivo: ' . $this->motivo)
            ->line('Si realizaste una puja en este lote, no se te realizará ningún cargo.')
            ->line('Si tenés dudas, contactanos en soporte@rialbids.com')
            ->salutation('El equipo de RialBids');
    }
}
