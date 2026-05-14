<?php

namespace MohitHasan\ActivityLogger;

use Illuminate\Support\ServiceProvider;

class ActivityLoggerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/activity-logger.php',
            'activity-logger'
        );

        $this->app->singleton('activity-logger', function () {
            return new ActivityLogger();
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/activity-logger.php' => config_path('activity-logger.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../database/migrations/create_activity_logs_table.php.stub' => database_path(
                    'migrations/' . date('Y_m_d_His', time()) . '_create_activity_logs_table.php'
                ),
            ], 'migrations');
        }
    }
}
