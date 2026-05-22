<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Si el usuario eligió idioma manualmente, lo guardamos en sesión
        if ($request->has('lang')) {
            $lang = in_array($request->lang, ['es', 'en']) ? $request->lang : 'es';
            session(['locale' => $lang]);
        }

        // Si hay idioma en sesión, lo usamos
        if (session()->has('locale')) {
            app()->setLocale(session('locale'));
            return $next($request);
        }

        // Detección automática por Accept-Language
        $acceptLanguage = $request->header('Accept-Language', 'es');
        
        if (str_contains($acceptLanguage, 'es')) {
            app()->setLocale('es');
        } else {
            app()->setLocale('en');
        }

        return $next($request);
    }
}
