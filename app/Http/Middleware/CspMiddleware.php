<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CspMiddleware
{
    /**
     * Manejar la solicitud entrante.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Agrega los encabezados CSP
        $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self' https://cdn.jsdelivr.net; style-src 'self' https://cdn.jsdelivr.net; img-src 'self' data:;");

        return $response;
    }
}
