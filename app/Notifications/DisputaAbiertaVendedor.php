<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DisputaAbiertaVendedor extends Notification
{
    public $dispute;

    public function __construct($dispute)
    {
        $this->dispute = $dispute;
    }

    public function via($notifiable): array { return ['mail']; }

    public function toMail($notifiable): MailMessage
    {
        $titulo = $this->dispute->auction->title ?? ('Lote #' . $this->dispute->auction_id);

        $subjects = [
            'es' => 'Un comprador abrio una disputa - ' . $titulo,
            'en' => 'A buyer opened a dispute - ' . $titulo,
            'de' => 'Ein Kaeufer hat eine Reklamation eroeffnet - ' . $titulo,
            'pt' => 'Um comprador abriu uma disputa - ' . $titulo,
        ];

        $locale = in_array($notifiable->locale, ['en','de','pt']) ? $notifiable->locale : 'es';
        $view = $locale === 'es' ? 'emails.disputa_vendedor' : 'emails.disputa_vendedor_' . $locale;

        return (new MailMessage)
            ->subject($subjects[$locale])
            ->view($view, [
                'user'    => $notifiable,
                'titulo'  => $titulo,
                'dispute' => $this->dispute,
            ]);
    }
}
