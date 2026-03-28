<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string check()
 *
 * @see \ThingsTelemetry\Traccar\Endpoints\Health
 */
class Health extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Health::class;
    }
}
