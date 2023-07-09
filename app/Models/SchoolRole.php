<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SchoolRole extends Model
{
    use HasFactory, SoftDeletes, UuidTrait;

    protected $guarded = ['id','uuid'];

    protected $hidden = ['id'];

    public function user_schools(){
        return $this->hasMany(UserSchool::class,'chool_role_id','id');
    }
}
