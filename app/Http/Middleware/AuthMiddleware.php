<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($guard == 'verified' && $user->is_verified || $guard == 'unverified') {
                return $next($request);
            }else if($guard == 'verified' && !$user->is_verified){
                return redirect('/verify-email');
            }
        }
        Auth::guard('web')->logout();
        return redirect('/login');
    }
}
