<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class School extends Model
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

    public function schoolPhoto(){
        return $this->hasOne(SchoolPhoto::class,'school_id','id');
    }

    public function semesters(){
        return $this->hasMany(Semester::class,'school_id','id');
    }

    public function classes(){
        return $this->hasMany(ClassRoom::class,'school_id','id');
    }

    public function userSchools(){
        return $this->hasMany(UserSchool::class,'school_id','id');
    }
}
