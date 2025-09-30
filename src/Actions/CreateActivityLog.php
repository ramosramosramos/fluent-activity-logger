<?php

declare(strict_types=1);

namespace KentJerone\ActivityLogger\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use KentJerone\ActivityLogger\ActivityLog;
use Throwable;

final class CreateActivityLog
{
    /**
     * @param  \Illuminate\Database\Eloquent\Model|null  $made_by_model
     * @param  string|null  $human_message
     * @param  array<mixed>|null  $human_extra_message
     * @param  array<mixed>|null  $developer_extra_message
     * @param  string|null  $developer_message
     * @param  array<mixed>|null  $application_extra_message
     * @return ActivityLog|null
     */
    public function handle(
        ?Model $made_by_model = null,
        ?string $human_message = null,
        ?array $human_extra_message = null,
        ?array $developer_extra_message = null,
        ?string $developer_message = null,
        ?array $application_extra_message = null,
    ): ?ActivityLog {
        // try catch
        // if activity log table is not exists then return null
        try {
            if (! Schema::hasTable(config()->string('activitylogger.table_name'))) {
                return null;
            }

            $except = config()->array('activitylogger.request_payload.except', []);

            $model = $made_by_model ?? auth()->user();

            return ActivityLog::create(attributes: [
                'made_by_model_id' => $model->getKey(),
                'made_by_model_type' => $model::class,

                'human_message' => $human_message,
                'human_extra_message' => $human_extra_message,

                'developer_message' => $developer_message,
                'developer_extra_message' => $developer_extra_message,
                'application_message' => [
                    'ip_address' => Request::ip(),
                    'user_agent' => Request::userAgent(),
                    'url' => Request::fullUrl(),
                    'method' => Request::method(),
                    'session_id' => session()->getId(),
                    'referer' => Request::header('referer'),
                    'status_code' => http_response_code(),
                    'request_payload' => Request::except($except),
                    // @phpstan-ignore-next-line
                    'old' => collect($made_by_model?->withoutRelations()->toArray())->except($except),
                    // @phpstan-ignore-next-line
                    'new' => collect($made_by_model?->getChanges())->except($except),
                ],
                'application_extra_message' => $application_extra_message,

            ]);

        } catch (Throwable $th) {
            if (app()->environment('testing')) {
                throw $th; // let PHPUnit show the real error
            }

            Log::error($th->getMessage());

            return null;
        }
    }
}
