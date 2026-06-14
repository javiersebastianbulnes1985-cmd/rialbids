<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Dispute;

class DisputaAbierta extends Notification
{
    public function __construct(public Dispute $dispute) {}

    public function via($notifiable): array { return ['mail']; }

    public function toMail($notifiable): MailMessage
    {
        $d = $this->dispute;
        $auction = $d->auction;
        $buyer   = $d->buyer;

        return (new MailMessage)
            ->subject('Nueva disputa abierta — Lote: ' . ($auction->title ?? '#' . $d->auction_id))
            ->greeting('Disputa abierta')
            ->line('Un comprador abrió una disputa en RialBids.')
            ->line('**Lote:** ' . ($auction->title ?? '#' . $d->auction_id))
            ->line('**Comprador:** ' . ($buyer->name ?? '-') . ' (' . ($buyer->email ?? '-') . ')')
            ->line('**Motivo:** ' . $d->reason)
            ->line('**Descripción:** ' . $d->description)
            ->action('Ver en el panel de disputas', url('/admin/pagos'))
            ->line('Revisá el caso y resolvé desde el panel de administración.')
            ->salutation('RialBids');
    }
}
