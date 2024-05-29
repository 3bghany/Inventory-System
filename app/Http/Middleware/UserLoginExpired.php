<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserLoginExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('last_activity')) {
            // The session has expired, log out the user and redirect
            return response()->json([
                'status'=> 'user inactivity',
                'message' => 'Session has expired',
            
            ], 401);
        }
        $request->session()->put('last_activity', now());

        return $next($request);
    }
}
