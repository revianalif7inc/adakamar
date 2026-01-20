<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('AdminMiddleware invoked', ['user' => auth()->user()?->id, 'check' => auth()->check(), 'role' => auth()->user()?->role ?? null]);
        if (auth()->check() && auth()->user()->role === 'admin') {
            $response = $next($request);
            \Illuminate\Support\Facades\Log::info('AdminMiddleware after next', ['status' => $response?->status()]);
            return $response;
        }

        abort(403, 'Unauthorized access');
    }
}
