<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ClassRoom extends Model
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
