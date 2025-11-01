<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TrackTelemetry\Traccar\Endpoints\Event
 */
class Event extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \TrackTelemetry\Traccar\Endpoints\Event::class;
    }
}
