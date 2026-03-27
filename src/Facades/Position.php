<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData delete(int $id)
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData deleteForDeviceInRange(int $deviceId, \Carbon\CarbonInterface $from, \Carbon\CarbonInterface $to)
 *
 * @see \ThingsTelemetry\Traccar\Endpoints\Position
 */
class Position extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Position::class;
    }
}
