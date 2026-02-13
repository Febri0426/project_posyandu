<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckProfileRoute
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->route()->named('profile')) {
            // aksi jika route bernama profile
            return response('Ini route PROFILE', 200);
        }

        return $next($request);
    }
}
