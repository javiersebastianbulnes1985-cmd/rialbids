<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Auction;

class PagoConfirmadoVendor extends Notification
{
    public function __construct(public Auction $auction) {}
    public function via($notifiable): array { return ["mail"]; }
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Vendiste — " . $this->auction->title . " · RialBids")
            ->view("emails.pago_confirmado_vendor", [
                "user" => $notifiable,
                "auction" => $this->auction,
            ]);
    }
}