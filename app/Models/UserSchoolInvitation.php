<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class UserSchoolInvitation extends Model
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

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function school(){
        return $this->belongsTo(School::class,'school_id','id');
    }

    public function schoolRole(){
        return $this->belongsTo(SchoolRole::class,'school_role_id','id');
    }

    public function invitationStatus(){
        return $this->belongsTo(InvitationStatus::class,'invitation_status_id','id');
    }
}
