<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserSchool;
use App\Models\School;
use App\Helpers\Helper;
use App\Models\User;

class SchoolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $userSchoolRole = UserSchool::with(['schoolRole'])
            ->where('user_id',auth()->user()->id)
            ->whereHas('school', function($q) use ($request){
                $q->where('uuid', $request->route('schoolId') ?? $request->school_id);
            })
            ->first()->schoolRole;

        if(in_array($userSchoolRole->slug, $guards)){
            return $next($request);
        }

        return Helper::getResponse('Akses ditolak.','Anda tidak bisa mengakses URL ini karena role anda tidak sesuai.',403);
    }
}
