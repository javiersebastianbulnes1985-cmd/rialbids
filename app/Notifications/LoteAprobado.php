<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Auction;

class LoteAprobado extends Notification
{
    public function __construct(public Auction $auction) {}
    public function via($notifiable): array { return ['mail']; }
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('✅ Tu lote fue aprobado — ' . $this->auction->title)
            ->greeting('¡Hola ' . $notifiable->name . '!')
            ->line('¡Buenas noticias! Tu lote ha sido aprobado y ya está publicado en RialBids.')
            ->line('**' . $this->auction->title . '**')
            ->line('Precio de salida: €' . number_format($this->auction->base_price, 0, ',', '.'))
            ->action('Ver tu lote', url('/auctions/' . $this->auction->id))
            ->line('¡Mucha suerte en la subasta!')
            ->salutation('El equipo de RialBids');
    }
}
