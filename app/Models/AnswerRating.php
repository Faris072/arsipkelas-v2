<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Traits\UserStampsTrait;
use App\Traits\UuidTrait;

class AnswerRating extends Model
{
    use HasFactory, SoftDeletes, UuidTrait, UserStampsTrait;

    protected $guarded = ['id','uuid'];

    protected $hidden = ['id'];

    public function userSchoolClassSubject(){
        return $this->belongsTo(UserSchoolClassSubject::class,'user_school_class_subject_id','id');
    }

    public function task(){
        return $this->belongsTo(Task::class,'task_id','id');
    }
}
