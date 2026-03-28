<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;
use ThingsTelemetry\Traccar\Dto\EventData;

/**
 * @method static EventData get(int $id)
 */
class Event extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Event::class;
    }
}
