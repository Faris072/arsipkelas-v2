<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Traits\UserStampsTrait;
use App\Traits\UuidTrait;

class Major extends Model
{
    use HasFactory, SoftDeletes, UuidTrait, UserStampsTrait;

    protected $guarded = ['id','uuid'];

    protected $hidden = ['id'];

    public function grade(){
        return $this->belongsTo(Grade::class,'grade_id','id');
    }

    public function classRooms(){
        return $this->hasMany(ClassRoom::class,'major_id','id');
    }
}
