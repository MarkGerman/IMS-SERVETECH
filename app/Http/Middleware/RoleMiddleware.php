<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
       if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check if user role is allowed
        if (!in_array($user->role, $roles)) {
            abort(403, 'You are not authorized to access this page.');
        }

        return $next($request);
    }
}
