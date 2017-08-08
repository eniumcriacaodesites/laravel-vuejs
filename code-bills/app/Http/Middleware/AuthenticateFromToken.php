<?php

namespace CodeBills\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class AuthenticateFromToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('web')->check() && Auth::guard('api')->check()) {
            $userId = Auth::guard('api')->user()->id;
            Auth::guard('web')->loginUsingId($userId);
        }

        if (!Auth::guard('web')->check()) {
            throw new AuthenticationException('Unauthenticated');
        }

        return $next($request);
    }
}
