<?php

declare(strict_types=1);

namespace KentJerone\ActivityLogger\Providers;

use Illuminate\Support\ServiceProvider;

class ActivityLoggerProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // 1. Auto-load migrations (optional)
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        // 2. Allow publishing migrations to app's database/migrations folder
        $this->publishes([
            __DIR__.'/../../database/migrations' => database_path('migrations'),
        ], 'activity-logger-migrations');

        $this->publishes([
            __DIR__.'/../../config/activitylogger.php' => config_path('activitylogger.php'),
        ], 'activity-logger-config');
    }
}
