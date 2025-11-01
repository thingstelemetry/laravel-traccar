<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ThingsTelemetry\Traccar\Endpoints\Device
 */
class Device extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Device::class;
    }
}
