<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role  // Role passed as parameter
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Check if user is logged in
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Check if user's role matches the required role
        if (auth()->user()->role !== $role) {
            abort(403, 'Unauthorized Access');
        }

        return $next($request);
    }
}