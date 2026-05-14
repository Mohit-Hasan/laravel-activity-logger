<?php

namespace MohitHasan\ActivityLogger\Facades;

use Illuminate\Support\Facades\Facade;

class ActivityLogger extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'activity-logger';
    }
}
