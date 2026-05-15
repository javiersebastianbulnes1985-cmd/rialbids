<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsVendedor
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || (!auth()->user()->isAdmin() && !auth()->user()->isSeller())) {
            abort(403, 'No autorizado');
        }

        return $next($request);
    }
}
