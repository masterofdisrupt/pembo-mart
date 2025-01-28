<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('login')->with('error', 'Please login first.');
        }

        if (Auth::user()->role === 'admin') { // Admin
            return $next($request);
        }

        Auth::logout();
        return redirect()->route('login')->with('error', 'Access denied.');
    }
}
