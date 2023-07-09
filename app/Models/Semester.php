<?php

namespace App\Models;

use App\Traits\UserStampsTrait;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Semester extends Model
{
    use HasFactory, SoftDeletes, UuidTrait, UserStampsTrait;

    protected $guarded = ['id','uuid'];

    protected $hidden = ['id'];

    public function school(){
        return $this->belongsTo(School::class,'school_id','id');
    }

    public function subjects(){
        return $this->hasMany(Subject::class,'semester_id','id');
    }
}
