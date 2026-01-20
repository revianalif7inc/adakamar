<?php

namespace App\Http\Middleware;

class TrimStrings
{
    protected $except = [];

    public function handle($request, $next)
    {
        return $next($request);
    }
}
