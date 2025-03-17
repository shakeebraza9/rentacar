<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $role = Auth::user()->role_id;
            if ($role === 0 || $role === 1 || $role === 2) {
                return $next($request); 
            }
        }

        // Not logged in OR invalid role
        return redirect()->route('weblogin')->with('error', 'Access denied.');
    }
}