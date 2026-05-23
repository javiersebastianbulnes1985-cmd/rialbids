<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Auction;

class LoteRechazado extends Notification
{
    public function __construct(public Auction $auction) {}
    public function via($notifiable): array { return ['mail']; }
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('❌ Tu lote no fue aprobado — ' . $this->auction->title)
            ->greeting('Hola ' . $notifiable->name)
            ->line('Lamentablemente tu lote no cumple con nuestros requisitos de publicación.')
            ->line('**' . $this->auction->title . '**')
            ->line('Motivo: ' . ($this->auction->rejection_reason ?? 'No especificado'))
            ->line('Podés corregir los problemas y volver a enviarlo.')
            ->action('Subir nuevo lote', url('/vendor/create'))
            ->line('Si tenés dudas, contactanos en soporte@rialbids.com')
            ->salutation('El equipo de RialBids');
    }
}
