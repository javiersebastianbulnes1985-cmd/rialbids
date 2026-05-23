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

        // Por defecto siempre español — solo cambia si el usuario elige manualmente
        app()->setLocale('es');

        return $next($request);
    }
}
