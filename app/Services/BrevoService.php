<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BrevoService
{
    public function addContactToList(string $email, string $name, string $locale): void
    {
        $listMap = [
            "es" => 3,
            "pt" => 4,
            "en" => 5,
            "de" => 6,
        ];
        $listId = $listMap[$locale] ?? 3;

        try {
            Http::withHeaders([
                "api-key" => config("services.brevo.key"),
                "Content-Type" => "application/json",
            ])->post("https://api.brevo.com/v3/contacts", [
                "email" => $email,
                "attributes" => ["FIRSTNAME" => $name],
                "listIds" => [$listId],
                "updateEnabled" => true,
            ]);
        } catch (\Exception $e) {
            Log::error("Brevo error: " . $e->getMessage());
        }
    }
}
