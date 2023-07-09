<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $guarded = ['id','uuid'];

    protected $hidden = ['id','password'];

    protected static function boot(){
        parent::boot();

        static::creating(function($model){
            $model->uuid = Str::uuid();
            $model->created_by = null;
        });

        static::saving(function($model){
            $model->updated_by = auth()->user()->id;
        });

        static::deleting(function($model){
            $model->deleted_by = auth()->user()->id;
        });
    }

    public function role(){
        return $this->belongsTo(Role::class,'role_id','id');
    }

    public function photoProfile(){
        return $this->hasOne(PhotoProfile::class,'user_id','id');
    }

    public function userSchools(){
        return $this->hasMany(PhotoProfile::class,'user_id','id');
    }
}
