<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Support\Str;

class UserSchoolClassSubject extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;

    protected $guarded = ['id','uuid'];

    protected $hidden = ['id'];

    protected $softCascade = ['answerRatings'];

    protected static function boot(){
        parent::boot();

        static::creating(function($model){
            $model->uuid = Str::uuid();
            $model->created_by = auth()->user()->id;
        });

        static::saving(function($model){
            $model->updated_by = auth()->user()->id;
        });

        static::deleting(function($model){
            $model->deleted_by = auth()->user()->id;
        });
    }

    public function subject(){
        return $this->belongsTo(Subject::class,'subject_id','id');
    }

    public function userSchoolClass(){
        return $this->belongsTo(UserSchoolClass::class,'user_school_class_id','id');
    }

    public function answerRatings(){
        return $this->hasOne(AnswerRating::class,'user_school_class_subject_id','id');
    }
}
