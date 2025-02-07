<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect(route('show.login'))->with('error', 'Please login first.');
        }

        if (Auth::user()->role === 'user') { // User
            return $next($request);
        }

        Auth::logout();
        return redirect(route('show.login'))->with('error', 'Access denied.');
    }

}
