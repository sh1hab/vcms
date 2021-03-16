<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class customAuth
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!session()->has('loginData')) {
            return redirect('login');
        }
        return $next($request);
    }
}
