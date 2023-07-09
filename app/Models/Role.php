<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Role extends Model
{
    use HasFactory, SoftDeletes, UuidTrait;

    protected $guarded = ['id','uuid'];

    protected $hidden = ['id'];

    public function users(){
        return $this->hasMany(User::class,'role_id','id');
    }
}
