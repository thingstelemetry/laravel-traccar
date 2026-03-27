<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \ThingsTelemetry\Traccar\Dto\EventData get(int $id)
 *
 * @see \ThingsTelemetry\Traccar\Endpoints\Event
 */
class Event extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Event::class;
    }
}
