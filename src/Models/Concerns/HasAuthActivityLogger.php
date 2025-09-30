<?php

declare(strict_types=1);

namespace KentJerone\ActivityLogger\Models\Concerns;

use KentJerone\ActivityLogger\Actions\CreateActivityLog;

// @phpstan-ignore-next-line
trait HasAuthActivityLogger
{
    public static function bootHasActivityLogger()
    {
        parent::booted();
        if ((bool) config('activitylogger.model_events.created')) {
            static::created(function ($model) {
                app(CreateActivityLog::class)->handle(
                    human_message: 'Created a '.class_basename($model),
                );
            });
        }

        if ((bool) config('activitylogger.model_events.updated')) {
            static::updated(function ($model) {
                app(CreateActivityLog::class)->handle(
                    human_message: 'Updated a '.class_basename($model),
                );
            });
        }

        if ((bool) config('activitylogger.model_events.deleted')) {
            static::deleted(function ($model) {
                app(CreateActivityLog::class)->handle(
                    human_message: 'Deleted a '.class_basename($model),
                );
            });
        }

        if ((bool) config('activitylogger.model_events.restored')) {
            static::restored(function ($model) {
                app(CreateActivityLog::class)->handle(
                    human_message: 'Restored a '.class_basename($model),
                );
            });
        }
        if ((bool) config('activitylogger.model_events.forceDeleted')) {
            static::forceDeleted(function ($model) {
                app(CreateActivityLog::class)->handle(
                    human_message: 'Force Deleted a '.class_basename($model),
                );
            });
        }

        if ((bool) config('activitylogger.model_events.creating')) {
            static::creating(function ($model) {
                app(CreateActivityLog::class)->handle(
                    human_message: 'Creating a '.class_basename($model),
                );
            });
        }

        if ((bool) config('activitylogger.model_events.updating')) {
            static::updating(function ($model) {
                app(CreateActivityLog::class)->handle(
                    human_message: 'Updating a '.class_basename($model),
                );
            });
        }

        if ((bool) config('activitylogger.model_events.deleting')) {
            static::deleting(function ($model) {
                app(CreateActivityLog::class)->handle(
                    human_message: 'Deleting a '.class_basename($model),
                );
            });
        }

    }
}
