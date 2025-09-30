<?php

namespace YourName\ActivityLogger\Traits;

use function logActivity;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function ($model) {
            logActivity('created', $model, $model->toArray());
        });

        static::updated(function ($model) {
            logActivity('updated', $model, [
                'old' => $model->getOriginal(),
                'new' => $model->getChanges(),
            ]);
        });

        static::deleted(function ($model) {
            logActivity('deleted', $model, $model->toArray());
        });
    }
}
