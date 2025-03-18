<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AppUserAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        dd(auth()->user());
        if (!Auth::guard('appuser')->check()) {
            dd('ssss');
            return redirect()->route('user.login'); // Adjust this route
        }
        dd('ddddd');
        return $next($request);
    }
}
