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
     * @param  string  $roles  Pipe-separated roles, e.g., "HR|Teacher|User" or just "Admin"
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        // Check if user is logged in
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();

        // Convert pipe-separated string to array
        $allowedRoles = explode('|', $roles);

        // Check if user's role is in allowed roles
        if (!in_array($user->role, $allowedRoles)) {
            abort(403, 'Unauthorized Access');
        }

        return $next($request);
    }
}