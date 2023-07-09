<?php

namespace App\Traits;

trait UserStampsTrait {
    protected static function boot(){
        parent::boot();

        static::creating(function($model){
            $model->created_by = auth()->user()->id;
        });

        static::saving(function($model){
            $model->updated_by = auth()->user()->id;
        });

        static::deleting(function($model){
            $model->deleted_by = auth()->user()->id;
        });
    }
}
