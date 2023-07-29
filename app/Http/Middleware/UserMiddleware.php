<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\Helper;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role = null, ...$roles)
    {
        $guard = $roles ?? [];
        $guard[] = $role;

        if(!in_array($guard, Auth()->user()->role_id)){
            return Helper::getResponse('','Akses ditolak!',403);
        }
        return $next($request);
    }
}
