<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PopupSubscribeController extends Controller
{
    public function store(Request $request)
    {
        $email = $request->input('email');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['error' => 'Email invalido'], 422);
        }

        try {
            Http::withHeaders([
                'api-key' => env('BREVO_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.brevo.com/v3/contacts', [
                'email' => $email,
                'listIds' => [15],
                'updateEnabled' => true,
            ]);
        } catch (\Exception $e) {
            Log::error('Popup subscribe error: ' . $e->getMessage());
        }

        return response()->json(['ok' => true]);
    }
}
