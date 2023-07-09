<?php

namespace App\Models;

use App\Traits\UserStampsTrait;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class UserSchool extends Model
{
    use HasFactory, SoftDeletes, UuidTrait, UserStampsTrait;

    protected $guarded = ['id','uuid'];

    protected $hidden = ['id'];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function school(){
        return $this->belongsTo(School::class,'school_id','id');
    }

    public function schoolRole(){
        return $this->belongsTo(SchoolRole::class,'school_role_id','id');
    }

    public function userSchoolClasses(){
        return $this->hasMany(UserSchoolClass::class,'user_school_id','id');
    }
}
