<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has role_id = 1 (Admin)
        if (!Auth::check() || Auth::user()->role_id != 1) {
            return redirect()->route('weblogin')->with('error', 'Access Denied: Admins Only.');
        }

        return $next($request);
    }
}