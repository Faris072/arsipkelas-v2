<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Subject extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id','uuid'];

    protected $hidden = ['id'];

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
