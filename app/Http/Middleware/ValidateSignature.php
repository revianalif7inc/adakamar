<?php

namespace App\Http\Middleware;

class ValidateSignature
{
    public function handle($request, $next)
    {
        return $next($request);
    }
}
