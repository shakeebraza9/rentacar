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
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->route('weblogin')->with('error', 'Access Denied.');
        }
    
        return $next($request);
    }
    
}