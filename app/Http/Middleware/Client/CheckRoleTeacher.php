<?php

namespace App\Http\Middleware\Client;

use App\Enums\DBConstant;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRoleTeacher
{
    /**
     * Handle an incoming request.
     *
     * @param Request  $request
     * @param Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // if (Auth::guard('client')->check()) {
        //     return redirect()->route('client.home');
        // }
        if (auth('client')->user()->user_type === DBConstant::USER_TYPE_TEACHER) {
            return $next($request);
        }

        throw new ModelNotFoundException();
    }
}
