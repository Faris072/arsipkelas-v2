<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserSchool;
use App\Helpers\Helper;

class TeacherSchoolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $userSchool = UserSchool::firstWhere('user_id', auth()->user()->id);
        if($userSchool->role_id == 1 || $userSchool->role_id == 3 || auth()->user()->id < 3){}
        else{
            return Helper::getResponse(null,'Akses Ditolak!',403);
        }
        return $next($request);
    }
}
