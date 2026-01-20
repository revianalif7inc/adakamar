<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        \Illuminate\Support\Facades\Log::info('AuthenticateMiddleware invoked', ['user' => auth()->user()?->id, 'check' => auth()->check()]);
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $response = $next($request);
        \Illuminate\Support\Facades\Log::info('AuthenticateMiddleware after next', ['status' => $response?->status()]);
        return $response;
    }
}
