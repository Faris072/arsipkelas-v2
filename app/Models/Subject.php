<?php

namespace App\Models;

use App\Traits\UserStampsTrait;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Subject extends Model
{
    use HasFactory, SoftDeletes, UuidTrait, UserStampsTrait;

    protected $guarded = ['id','uuid'];

    protected $hidden = ['id'];

    public function classRoom(){
        return $this->belongsTo(ClassRoom::class,'class_room_id','id');
    }

    public function semester(){
        return $this->belongsTo(Semester::class,'semester_id','id');
    }

    public function userSchoolClassSubjects(){
        return $this->hasMany(UserSchoolClassSubject::class,'subject_id','id');
    }

    public function tasks(){
        return $this->hasMany(Task::class,'subject_id','id');
    }
}
