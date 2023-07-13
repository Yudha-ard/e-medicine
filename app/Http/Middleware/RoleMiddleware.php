<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (Auth::check() && in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }
        
        $roles = Auth::user()->role;

        if ($roles === "customer") {
            return redirect('/user/dashboard');
        } elseif ($roles === "administrator") {
            return redirect('/admin/dashboard');
        } elseif ($roles === "apoteker") {
            return redirect('/apotek/dashboard');
        } elseif ($roles === "kurir") {
            return redirect('/kurir/dashboard');
        } elseif ($roles === "anonymous") {
            return redirect('/');
        }

    }
}
