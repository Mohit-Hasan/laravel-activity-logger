<?php

namespace MohitHasan\ActivityLogger\Traits;

use MohitHasan\ActivityLogger\Facades\ActivityLogger;

trait LogsActivity
{
    public static function bootLogsActivity(): void
    {
        $events = config('activity-logger.log_events', ['created', 'updated', 'deleted', 'restored']);
        $ignore = config('activity-logger.ignore_events', ['retrieved']);

        foreach ($events as $event) {
            if (!in_array($event, $ignore)) {
                static::registerModelEvent($event, function ($model) use ($event) {
                    try {
                        ActivityLogger::action($event)
                            ->description(class_basename($model) . ' was ' . $event)
                            ->on($model)
                            ->log();
                    } catch (\Throwable $e) {
                    }
                });
            }
        }
    }
}
