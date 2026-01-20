<?php

namespace App\Http\Middleware;

class PreventRequestsDuringMaintenance
{
    public function handle($request, $next)
    {
        return $next($request);
    }
}
