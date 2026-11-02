<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenExpiryMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->user()?->currentAccessToken();

        if ($token && $token->expires_at && now()->greaterThan($token->expires_at)) {
            $token->delete(); // remove expired token
            return response()->json([
                'message' => 'Token expired, please login again.'
            ], 401);
        }

        return $next($request);
    }
}
