<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $supported = ['es', 'en', 'pt', 'it', 'de'];

        if ($request->has('lang')) {
            $lang = in_array($request->lang, $supported) ? $request->lang : 'es';
            session(['locale' => $lang]);
        }

        if (session()->has('locale')) {
            app()->setLocale(session('locale'));
            return $next($request);
        }

        $acceptLanguage = $request->header('Accept-Language', 'es');

        if (str_contains($acceptLanguage, 'pt')) {
            app()->setLocale('pt');
        } elseif (str_contains($acceptLanguage, 'it')) {
            app()->setLocale('it');
        } elseif (str_contains($acceptLanguage, 'de')) {
            app()->setLocale('de');
        } elseif (str_contains($acceptLanguage, 'en')) {
            app()->setLocale('en');
        } else {
            app()->setLocale('es');
        }

        return $next($request);
    }
}
