<?php

namespace App\Http\Middleware;

class RedirectIfAuthenticated
{
    public function handle($request, $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) {
                return redirect('/');
            }
        }

        return $next($request);
    }
}
