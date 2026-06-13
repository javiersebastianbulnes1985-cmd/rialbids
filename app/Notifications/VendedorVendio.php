<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Auction;

class VendedorVendio extends Notification
{
    public function __construct(public Auction $auction) {}

    public function via($notifiable): array { return ['mail']; }

    public function toMail($notifiable): MailMessage
    {
        $subjects = [
            'es' => 'Vendiste tu lote en RialBids — ' . $this->auction->title,
            'en' => 'You sold your lot on RialBids — ' . $this->auction->title,
            'de' => 'Sie haben Ihr Los bei RialBids verkauft — ' . $this->auction->title,
            'pt' => 'Vendeu o seu lote na RialBids — ' . $this->auction->title,
        ];
        $locale = in_array($notifiable->locale, ['en','de','pt']) ? $notifiable->locale : 'es';
        $view = $locale === 'es' ? 'emails.vendedor_vendio' : 'emails.vendedor_vendio_' . $locale;

        $precio   = (float) $this->auction->final_price;
        $comision = round($precio * 0.09 + 3, 2);
        $neto     = round($precio - $comision, 2);

        return (new MailMessage)
            ->subject($subjects[$locale])
            ->view($view, [
                'user'     => $notifiable,
                'auction'  => $this->auction,
                'precio'   => $precio,
                'comision' => $comision,
                'neto'     => $neto,
            ]);
    }
}
