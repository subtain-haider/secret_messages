<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureTokenIsValid
{
    public function handle(Request $request, Closure $next)
    {
        // Check for a valid token or other security checks
        if (!$request->header('X-Secure-Token') || $request->header('X-Secure-Token') !== env('API_SECURE_TOKEN')) {
            abort(403);
        }

        return $next($request);
    }
}
