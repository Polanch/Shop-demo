<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Please login to continue.');
        }

        // Check if user has the required role
        if (Auth::user()->role !== $role) {
            Auth::logout();
            return redirect('/')->with('error', 'Unauthorized access. You have been logged out.');
        }

        return $next($request);
    }
}
