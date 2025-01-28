<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class AgentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('login')->with('error', 'Please login first.');
        }

        if (Auth::user()->role === 'agent') { // Agent
            return $next($request);
        }

        Auth::logout();
        return redirect('/')->with('error', 'Access denied.');
    }

}
