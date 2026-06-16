<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Auction;

class PagoConfirmadoComprador extends Notification
{
    public function __construct(public Auction $auction) {}
    public function via($notifiable): array { return ["mail"]; }
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Pago confirmado — " . $this->auction->title . " · RialBids")
            ->view("emails.pago_confirmado_comprador", [
                "user" => $notifiable,
                "auction" => $this->auction,
            ]);
    }
}