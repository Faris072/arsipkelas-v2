<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Traits\UserStampsTrait;
use App\Traits\UuidTrait;

class ClassRoom extends Model
{
    use HasFactory, SoftDeletes, UuidTrait, UserStampsTrait;

    protected $guarded = ['id','uuid'];

    protected $hidden = ['id'];

    public function school(){
        return $this->belongsTo(School::class,'school_id','id');
    }

    public function major(){
        return $this->belongsTo(Major::class,'major_id','id');
    }

    public function subjects(){
        return $this->hasMany(Subject::class,'class_room_id','id');
    }

    public function userSchoolClasses(){
        return $this->hasMany(UserSchoolClass::class,'class_room_id','id');
    }
}
