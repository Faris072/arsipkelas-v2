<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\UserStampsTrait;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, UuidTrait, UserStampsTrait;

    protected $guarded = ['id','uuid'];

    protected $hidden = ['uuid','password'];

    public function role(){
        return $this->belongsTo(Role::class,'role_id','id');
    }

    public function photoProfile(){
        return $this->hasOne(PhotoProfile::class,'user_id','id');
    }

    public function userSchools(){
        return $this->hasMany(PhotoProfile::class,'user_id','id');
    }
}
