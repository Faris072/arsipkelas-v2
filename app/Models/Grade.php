<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Grade extends Model
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

    public function majors(){
        return $this->hasMany(Major::class,'grade_id','id');
    }
}
