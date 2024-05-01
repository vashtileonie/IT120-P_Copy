<?php

namespace App\Traits;

use App\Models\AuditLog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function (Model $model) {
            self::audit('created', $model);
        });

        static::updated(function (Model $model) {
            self::audit('updated', $model);
        });

        static::deleted(function (Model $model) {
            self::audit('deleted', $model);
        });

        static::creating(function ($model) {
            $model->created_by = auth()->id() ?? 1;
            $model->updated_by = NULL;
            $model->updated_at = NULL;
        });

        static::updating(function ($model) {
            $model->updated_by = auth()->id() ?? 1;
        });

        static::deleting(function ($model) {
            $model->deleted_by = auth()->id() ?? 1;
            $model->timestamps = false;
            $model->saveQuietly();
        });
    }

    protected static function audit($description, $model)
    {
        // types that will reset data providers
        $types = [
            'created',
            'deleted'
        ];

        // check if we should reset provider
        if (in_array($description, $types)
            && method_exists(self::class, 'getDataProviderKey')
        ) {
            // we need to clear data provider cache to reload its latest values
            self::forgetMe();
        }

        // do log
        $do_log = true;

        // check if auditable
        if (property_exists($model, 'auditable')) {
            $do_log = $model->auditable;
        }

        // if do log
        if ($do_log) {
            AuditLog::create([
                'description'  => $description,
                'subject_id'   => $model->id ?? null,
                'subject_type' => get_class($model) ?? null,
                'user_id'      => auth()->id() ?? null,
                'properties'   => $model ?? null,
                'host'         => request()->ip() ?? null,
            ]);
        }
    }
}
