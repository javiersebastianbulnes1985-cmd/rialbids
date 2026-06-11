<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Auction;

class BienvenidaVendor extends Notification
{
    protected ?string $password;

    public function __construct(?string $password = null)
    {
        $this->password = $password;
    }

    public function via($notifiable): array { return ['mail']; }

    public function toMail($notifiable): MailMessage
    {
        $subjects = [
            'es' => 'Bienvenido a RialBids — Tu primer lote es GRATIS',
            'en' => 'Welcome to RialBids — Your first lot is FREE',
            'de' => 'Willkommen bei RialBids — Dein erstes Los ist GRATIS',
            'pt' => 'Bem-vindo à RialBids — O teu primeiro lote é GRÁTIS',
        ];
        $locale = in_array($notifiable->locale, ['en','de','pt']) ? $notifiable->locale : 'es';
        $view = $locale === 'es' ? 'emails.bienvenida_vendor' : 'emails.bienvenida_vendor_' . $locale;

        $subastas = Auction::where('status','active')->orderBy('end_time','asc')->take(2)->get();

        return (new MailMessage)
            ->subject($subjects[$locale])
            ->view($view, [
                'user' => $notifiable,
                'password' => $this->password,
                'subastas' => $subastas,
            ]);
    }
}
