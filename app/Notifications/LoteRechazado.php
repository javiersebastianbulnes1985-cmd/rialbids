<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Auction;

class LoteRechazado extends Notification
{
    public function __construct(public Auction $auction) {}
    public function via($notifiable): array { return ["mail"]; }
    public function toMail($notifiable): MailMessage
    {
        $locale = $notifiable->locale ?? app()->getLocale();
        $subjects = [
            "es" => "Tu lote no fue aprobado: " . $this->auction->title,
            "pt" => "O seu lote nao foi aprovado: " . $this->auction->title,
            "de" => "Ihr Los wurde nicht genehmigt: " . $this->auction->title,
            "en" => "Your lot was not approved: " . $this->auction->title,
        ];
        return (new MailMessage)
            ->subject($subjects[$locale] ?? $subjects["es"])
            ->view("emails.lote_rechazado", [
                "user" => $notifiable,
                "auction" => $this->auction,
                "locale" => $locale,
            ]);
    }
}