<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Support\Str;

class InvitationStatus extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;

    protected $guarded = ['id','uuid'];

    protected $hidden = ['id'];

    protected $softCascade = ['userSchoolInvitations'];

    protected static function boot(){
        parent::boot();

        static::creating(function($model){
            $model->uuid = Str::uuid();
        });
    }

    public function userSchoolInvitations(){
        return $this->hasMany(UserSchoolInvitation::class,'invitation_status_id','id');
    }
}
