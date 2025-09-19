<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        Log::info('Checking role', ['user_role' => $request->user()->role->name, 'required_role' => $role]);
        if (! $request->user()->role || strtolower($request->user()->role->name) !== strtolower($role)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}