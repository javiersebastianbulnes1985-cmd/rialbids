<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BienvenidaRialBids extends Notification
{
    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Bienvenido a RialBids')
            ->greeting('Hola ' . $notifiable->name . ',')
            ->line('Tu cuenta en RialBids fue creada exitosamente.')
            ->line('En RialBids encontraras objetos unicos en subasta cada semana: joyas, arte, relojes, antiguedades y mucho mas.')
            ->action('Ver subastas', url('/'))
            ->line('Si tienes alguna pregunta, visita nuestra seccion de preguntas frecuentes o escribenos a info@rialbids.com.')
            ->salutation('El equipo de RialBids');
    }
}
