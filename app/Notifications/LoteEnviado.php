<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Auction;

class LoteEnviado extends Notification
{
    public function __construct(public Auction $auction) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    private function getTrackingUrl(): ?string
    {
        $urls = [
            "correos"    => "https://www.correos.es/es/es/herramientas/localizador/envios/detalle?tracking-number=",
            "correos_pt" => "https://www.ctt.pt/feapl_2/app/open/objectSearch/objectSearch.jspx?request_locale=pt&objects=",
            "dhl"        => "https://www.dhl.com/es-es/home/tracking.html?tracking-id=",
            "gls"        => "https://gls-group.com/track/",
            "mrw"        => "https://www.mrw.es/seguimiento_envios/MRW_resultados_consultas.asp?Numero=",
            "seur"       => "https://www.seur.com/livetracking/?segOnlineIdentificador=",
            "ups"        => "https://www.ups.com/track?tracknum=",
            "fedex"      => "https://www.fedex.com/fedextrack/?tracknumbers=",
            "nacex"      => "https://www.nacex.es/seguimientoDetalle.do?agencia_origen=&numero_albaran=",
        ];
        $base = $urls[$this->auction->tracking_carrier] ?? null;
        return $base ? $base . $this->auction->tracking_number : null;
    }

    public function toMail($notifiable): MailMessage
    {
        $carrierNames = [
            "correos" => "Correos", "correos_pt" => "CTT Portugal",
            "dhl" => "DHL", "gls" => "GLS", "mrw" => "MRW",
            "seur" => "SEUR", "ups" => "UPS", "fedex" => "FedEx",
            "nacex" => "Nacex", "autre" => "Otro",
        ];
        $carrierName = $carrierNames[$this->auction->tracking_carrier] ?? $this->auction->tracking_carrier;
        $trackingUrl = $this->getTrackingUrl();

        $mail = (new MailMessage)
            ->subject("📦 Tu lote ha sido enviado — RialBids")
            ->greeting("¡Hola {$notifiable->name}!")
            ->line("Tu lote **{$this->auction->title}** ha sido enviado.")
            ->line("Courier: **{$carrierName}** — Nº tracking: **{$this->auction->tracking_number}**")
            ->line("Una vez que lo recibas, confirmá la recepción en tu perfil para liberar el pago al vendedor.");

        if ($trackingUrl) {
            $mail->line("👉 [Trackear tu envío aquí](" . $trackingUrl . ")");
        }

        $mail->action("Confirmar recepción", url("/perfil"))
             ->line("Si no confirmás en 14 días, el pago se liberará automáticamente.")
             ->salutation("El equipo de RialBids");

        return $mail;
    }
}
