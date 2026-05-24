<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DetectLanguage
{
    public function handle(Request $request, Closure $next)
    {
        $accept = $request->header('Accept-Language', 'es');
        $lang = 'es';
        if (preg_match('/^(en|de|nl|pt|fr|it|sv)/i', $accept, $m)) {
            $lang = strtolower($m[1]);
        }
        app()->setLocale($lang);
        view()->share('detected_lang', $lang);
        return $next($request);
    }
}
