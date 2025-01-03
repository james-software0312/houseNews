<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {

        // Check if the user is authenticated and has the required role
        if (Auth::check()) {
            if(Auth::user()->is_admin && $role == 'admin')
                return $next($request);
            if(!Auth::user()->is_admin && $role == 'owner')
                return $next($request);
            return redirect('/dashboard')->withErrors('You do not have access to this resource.');
        }
        Auth::guard('web')->logout();
        return redirect('/login');
    }
}
