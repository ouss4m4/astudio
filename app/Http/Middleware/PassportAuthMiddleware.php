<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// override passport redirect to /login with 401 (api)
class PassportAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('api')->guest()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
