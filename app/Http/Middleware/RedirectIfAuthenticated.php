<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                
                $roles = Auth::guard($guard)->user()->role;
                
                if ($roles === "customer") {
                    return redirect('/user/dashboard');
                } elseif ($roles === "administrator") {
                    return redirect('/admin/dashboard');
                } elseif ($roles === "apoteker") {
                    return redirect('/apotek/dashboard');
                } elseif ($roles === "kurir") {
                    return redirect('/kurir/dashboard');
                } elseif ($roles === "anonymous") {
                    Auth::guard($guard)->logout();
                    return redirect('/');
                }
            }
        }

        return $next($request);
    }
}
