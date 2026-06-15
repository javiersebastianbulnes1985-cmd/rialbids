<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResolucionDisputa extends Notification
{
    public $dispute;
    public $favor;
    public $destinatario;

    public function __construct($dispute, string $favor, string $destinatario)
    {
        $this->dispute = $dispute;
        $this->favor = $favor;
        $this->destinatario = $destinatario;
    }

    public function via($notifiable): array { return ['mail']; }

    public function toMail($notifiable): MailMessage
    {
        $titulo = $this->dispute->auction->title ?? ('Lote #' . $this->dispute->auction_id);

        $subjects = [
            'es' => 'Resolucion de tu disputa - ' . $titulo,
            'en' => 'Resolution of your dispute - ' . $titulo,
            'de' => 'Loesung Ihrer Reklamation - ' . $titulo,
            'pt' => 'Resolucao da sua disputa - ' . $titulo,
        ];

        $locale = in_array($notifiable->locale, ['en','de','pt']) ? $notifiable->locale : 'es';
        $view = $locale === 'es' ? 'emails.resolucion_disputa' : 'emails.resolucion_disputa_' . $locale;

        return (new MailMessage)
            ->subject($subjects[$locale])
            ->view($view, [
                'user'         => $notifiable,
                'titulo'       => $titulo,
                'favor'        => $this->favor,
                'destinatario' => $this->destinatario,
            ]);
    }
}
