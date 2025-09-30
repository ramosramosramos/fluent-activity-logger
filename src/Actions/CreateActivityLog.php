<?php

declare(strict_types=1);

namespace KentJerone\ActivityLogger\Actions;

use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use KentJerone\ActivityLogger\ActivityLog;



final class CreateActivityLog
{
    /**
     * @param \Illuminate\Database\Eloquent\Model $made_by_model
     * @param string|null $human_message
     * @param string|null $developer_message
     * @param string[]|null $human_extra_message
     * @param string[]|null $developer_extra_message
     * @param string[]|null $application_extra_message
     * @return ActivityLog|null
     */
    public function handle(
        ?Model $made_by_model =null,
        ?string $human_message = null,
        ?array $human_extra_message = null,
        ?array $developer_extra_message = null,
        ?string $developer_message = null,
        ?array $application_extra_message = null,
    ): ?ActivityLog {
        // try catch
        // if activity log table is not exists then return null
        try {
            if (!Schema::hasTable(config()->string('activitylogger.table_name'))) {
                return null;
            }

            /**
             * @var Model | \App\Models\User  $user
             */

            $user = $made_by_model ?? auth()->user();

            return ActivityLog::create(attributes: [
                'made_by_model_id' => $user->getKey(),
                'made_by_model_type' => $user::class,

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
                    'request_payload' => Request::except(config('activitylogger.request_payload.except') ?? [
                        'password',
                        'password_confirmation',
                    ]),
                    //@phpstan-ignore-next-line
                    'old' => $made_by_model->getOriginal(),
                    //@phpstan-ignore-next-line
                    'new' => $made_by_model->getChanges(),
                ],
                'application_extra_message' => $application_extra_message,

            ]);

        } catch (Throwable $th) {
            Log::error($th->getMessage());
            return null;
        }
    }
}
