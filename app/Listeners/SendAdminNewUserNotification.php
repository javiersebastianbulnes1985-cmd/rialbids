<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;

class SendAdminNewUserNotification
{
    public function handle(Registered $event): void
    {
        $user = $event->user;

        Mail::raw(
            "Nuevo usuario registrado en RialBids:\n\n" .
            "Nombre: {$user->name}\n" .
            "Email: {$user->email}\n" .
            "Fecha: " . now()->format('d/m/Y H:i') . "\n\n" .
            "Ver en admin: https://rialbids.com/admin",
            function ($message) {
                $message->to('admin@rialbids.com')
                        ->subject('🆕 Nuevo usuario en RialBids');
            }
        );
    }
}
