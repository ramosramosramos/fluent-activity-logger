<?php
declare(strict_types=1);

use KentJerone\ActivityLogger\ActivityLog;

use KentJerone\ActivityLogger\Actions\CreateActivityLog;

/**
 * Create a new ActivityLog model.
 *
 * @return \KentJerone\ActivityLogger\ActivityLog
 */
if (!function_exists('activityLog')) {
    function activityLog(): ActivityLog
    {
        return new ActivityLog();
    }
}

/**
 * Create a new CreateActivityLog action.
 *
 * @param \Illuminate\Database\Eloquent\Model|null $made_by_model
 * @param string|null $human_message
 * @param array|null $human_extra_message
 * @param string|null $developer_message
 * @param array|null $developer_extra_message
 * @param array|null $application_extra_message
 *
 * @return \KentJerone\ActivityLogger\Actions\CreateActivityLog
 */
if (!function_exists('createActivityLog')) {
    function createActivityLog(
        ?\Illuminate\Database\Eloquent\Model $made_by_model = null,
        ?string $human_message = null,
        ?array $human_extra_message = null,
        ?string $developer_message = null,
        ?array $developer_extra_message = null,
        ?array $application_extra_message = null,
    ): ?ActivityLog {
        return (new CreateActivityLog())->handle(
            $made_by_model,
            $human_message,
            $human_extra_message,
            $developer_message,
            $developer_extra_message,
            $application_extra_message
        );
    }
}

