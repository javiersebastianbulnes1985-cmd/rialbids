<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use App\Notifications\BienvenidaRialBids;

class WebhookLeadController extends Controller
{
    public function store(Request $request)
    {
        $email = $request->input('email');
        $name = $request->input('name', 'Usuario');
        $type = $request->input('type', 'buyer');

        if (!$email) {
            return response()->json(['error' => 'Email requerido'], 400);
        }

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => bcrypt(Str::random(16)),
                'locale' => $request->input('locale', 'es'),
                'role' => $type === 'vendor' ? 'seller' : 'bidder',
            ]
        );

        if ($user->wasRecentlyCreated) {
            $user->notify(new BienvenidaRialBids());
        }

        return response()->json(['success' => true, 'user_id' => $user->id]);
    }
}
