<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddCustomCspHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $scriptSrc = implode(' ', [
            "'self'",
            "'unsafe-eval'",
            "'unsafe-inline'", // Also adding this for maximum compatibility
            "cdn.jsdelivr.net",
        ]);

        $styleSrc = implode(' ', [
            "'self'",
            "'unsafe-inline'",
            "fonts.bunny.net",
        ]);

        $fontSrc = implode(' ', [
            "'self'",
            "fonts.bunny.net",
        ]);

        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; " .
            "script-src {$scriptSrc}; " .
            "style-src {$styleSrc}; " .
            "font-src {$fontSrc}; " .
            "img-src 'self' data:; " .
            "object-src 'none'; " .
            "base-uri 'self'; " .
            "form-action 'self';"
        );

        return $response;
    }
}