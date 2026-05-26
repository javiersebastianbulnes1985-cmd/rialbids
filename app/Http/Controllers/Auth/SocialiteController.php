<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => bcrypt(str()->random(24)),
                'email_verified_at' => now(),
            ]
        );

        Auth::login($user, true);
        return redirect()->intended('/dashboard');
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $fbUser = Socialite::driver('facebook')->user();

        $user = User::updateOrCreate(
            ['email' => $fbUser->getEmail()],
            [
                'name' => $fbUser->getName(),
                'facebook_id' => $fbUser->getId(),
                'avatar' => $fbUser->getAvatar(),
                'password' => bcrypt(str()->random(24)),
                'email_verified_at' => now(),
            ]
        );

        Auth::login($user, true);
        return redirect()->intended('/dashboard');
    }
}
