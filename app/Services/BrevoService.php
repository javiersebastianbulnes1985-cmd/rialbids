<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BrevoService
{
    private string $apiKey;
    private string $baseUrl = 'https://api.brevo.com/v3';

    public function __construct()
    {
        $this->apiKey = config('services.brevo.key');
    }

    public function notificarNuevoLote($auction): void
    {
        try {
            $contacts = $this->obtenerTodosLosContactos();
            if (empty($contacts)) {
                Log::info('BrevoService: no hay contactos para notificar');
                return;
            }

            $imageUrl = $auction->image_path
                ? asset('storage/' . $auction->image_path)
                : asset('images/logo.png');

            $htmlContent = '
<div style="font-family:sans-serif;max-width:600px;margin:0 auto">
  <div style="background:#1a3a6b;padding:24px;text-align:center">
    <h1 style="color:#c9a84c;margin:0;font-size:22px">RialBids</h1>
    <p style="color:#fff;margin:4px 0 0;font-size:13px">Subastas Online</p>
  </div>
  <div style="padding:32px;border:1px solid #e5e7eb;border-top:none">
    <h2 style="color:#1a3a6b;margin:0 0 16px">🔨 Nueva subasta activa</h2>
    <img src="' . $imageUrl . '" style="width:100%;max-height:300px;object-fit:cover;border-radius:8px;margin-bottom:16px">
    <h3 style="color:#1f2937;margin:0 0 8px">' . e($auction->title) . '</h3>
    <p style="color:#6b7280;margin:0 0 16px">Precio inicial: <strong style="color:#1a3a6b">€' . number_format($auction->current_price, 2) . '</strong> — Cierra: ' . \Carbon\Carbon::parse($auction->end_time)->format('d/m/Y') . '</p>
    <a href="' . url('/auctions/' . $auction->id) . '" style="background:#c9a84c;color:#fff;padding:14px 28px;border-radius:8px;text-decoration:none;font-weight:700;display:inline-block;margin-bottom:24px">Ver la subasta →</a>
    <hr style="border:none;border-top:1px solid #e5e7eb;margin:24px 0">
    <p style="font-size:12px;color:#9ca3af">¿Tenés objetos para vender? <a href="' . url('/seller-request') . '" style="color:#1a3a6b">Publicá tu primer lote gratis →</a></p>
  </div>
</div>';

            foreach ($contacts as $contact) {
                if (empty($contact['email'])) continue;
                try {
                    Http::withHeaders([
                        'api-key' => $this->apiKey,
                        'Content-Type' => 'application/json',
                    ])->post($this->baseUrl . '/smtp/email', [
                        'sender' => ['name' => 'RialBids', 'email' => 'info@rialbids.com'],
                        'to' => [['email' => $contact['email'], 'name' => $contact['firstName'] ?? '']],
                        'subject' => '🔨 Nueva subasta: ' . $auction->title . ' — desde €' . number_format($auction->current_price, 0),
                        'htmlContent' => $htmlContent,
                    ]);
                } catch (\Exception $e) {
                    Log::error('BrevoService error enviando a ' . $contact['email'] . ': ' . $e->getMessage());
                }
            }
            Log::info('BrevoService: notificacion nuevo lote #' . $auction->id . ' enviada a ' . count($contacts) . ' contactos');
        } catch (\Exception $e) {
            Log::error('BrevoService::notificarNuevoLote error: ' . $e->getMessage());
        }
    }

    private function obtenerTodosLosContactos(): array
    {
        $contacts = [];
        $offset = 0;
        $limit = 500;
        do {
            $response = Http::withHeaders([
                'api-key' => $this->apiKey,
            ])->get($this->baseUrl . '/contacts', [
                'limit' => $limit,
                'offset' => $offset,
            ]);
            $data = $response->json();
            $batch = $data['contacts'] ?? [];
            $contacts = array_merge($contacts, $batch);
            $offset += $limit;
        } while (count($batch) === $limit);
        return $contacts;
    }
}