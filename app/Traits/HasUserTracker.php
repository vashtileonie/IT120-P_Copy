<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait HasUserTracker
{
    public static function bootHasUserTracker()
    {
        static::creating(function ($model) {
            if (! $model->created_by) {
                $user_id = Auth::user()?->id;
                $model->created_by = $user_id;
                $model->updated_by = $user_id;
            }
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user()?->id;
        });

        static::deleting(function ($model) {
            if (! array_key_exists('deleted_by', $model->attributesToArray())) {
                return;
            }

            if (method_exists($model, 'trashed') && $model->email) {
                $model->email = 'deleted_'. time() .'_'. $model->email;
            }

            $model->deleted_by = Auth::user()?->id;
            $model->save();
        });
    }


    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }


    public function updater()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }


    public function deleter()
    {
        return $this->hasOne(User::class, 'id', 'deleted_by');
    }
}
