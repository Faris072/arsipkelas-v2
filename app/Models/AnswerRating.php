<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class AnswerRating extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id','uuid'];

    protected $hidden = ['id'];

    protected static function boot(){
        parent::boot();

        static::creating(function($model){
            $model->uuid = Str::uuid();
        });
    }

    public function userSchoolClassSubject(){
        return $this->belongsTo(UserSchoolClassSubject::class,'user_school_class_subject_id','id');
    }

    public function task(){
        return $this->belongsTo(Task::class,'task_id','id');
    }
}
