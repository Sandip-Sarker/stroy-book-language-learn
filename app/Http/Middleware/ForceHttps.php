<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    /**
     * Handle an incoming request.
     * Forces HTTPS scheme for URL generation when APP_URL starts with https.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Force HTTPS scheme if APP_URL uses https
        if (str_starts_with(config('app.url'), 'https')) {
            URL::forceScheme('https');
            
            // Also set the request to appear as secure for form actions etc.
            $request->server->set('HTTPS', 'on');
        }

        return $next($request);
    }
}
