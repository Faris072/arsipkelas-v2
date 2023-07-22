<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Support\Str;

class Semester extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;

    protected $guarded = ['id','uuid'];

    protected $hidden = ['id'];

    protected $softCascade = ['subjects'];

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

    public function school(){
        return $this->belongsTo(School::class,'school_id','id');
    }

    public function subjects(){
        return $this->hasMany(Subject::class,'semester_id','id');
    }
}
