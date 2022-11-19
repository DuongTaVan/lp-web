<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckLoginClient

{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (($request->path()) == 'register') {
            return $next($request);
        }
        if (Auth::guard('client')->check()) {
            return redirect()->route('client.home');
        }
        return $next($request);
    }
}
