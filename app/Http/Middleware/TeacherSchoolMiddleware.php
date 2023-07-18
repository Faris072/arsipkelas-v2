<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserSchool;
use App\Models\School;
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
        $schoolIdRoute = $request->route('id');
        $schoolIdRequest = $request->school_id;
        if(!$schoolIdRoute && !$schoolIdRequest){
            return Helper::getResponse(null,'Sekolah tidak terdefinisikan.', 400);
        }

        $userSchool = UserSchool::where('user_id', auth()->user()->id)->where('school_id', School::firstWhere('uuid', $schoolIdRoute ?? $schoolIdRequest)->id)->first();
        if($userSchool->school_role_id == 1 || $userSchool->school_role_id == 3 || auth()->user()->id < 3){}
        else{
            return Helper::getResponse(null,'Akses Ditolak!',403);
        }
        return $next($request);
    }
}
