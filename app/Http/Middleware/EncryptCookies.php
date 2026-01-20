<?php

namespace App\Http\Middleware;

class EncryptCookies
{
    protected $except = [];

    public function handle($request, $next)
    {
        return $next($request);
    }
}
