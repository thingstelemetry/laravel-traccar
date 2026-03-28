<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection combined(array $deviceIds, array $groupIds, \Carbon\CarbonInterface $from, \Carbon\CarbonInterface $to)
 * @method static \Illuminate\Support\Collection route(array $deviceIds, array $groupIds, \Carbon\CarbonInterface $from, \Carbon\CarbonInterface $to)
 * @method static \Illuminate\Support\Collection events(array $deviceIds, array $groupIds, \Carbon\CarbonInterface $from, \Carbon\CarbonInterface $to, ?array $types = null, ?array $alarms = null)
 * @method static \Illuminate\Support\Collection geofences(array $deviceIds, array $groupIds, \Carbon\CarbonInterface $from, \Carbon\CarbonInterface $to, ?array $geofenceIds = null)
 * @method static \Illuminate\Support\Collection summary(array $deviceIds, array $groupIds, \Carbon\CarbonInterface $from, \Carbon\CarbonInterface $to, bool $daily = false)
 * @method static \Illuminate\Support\Collection trips(array $deviceIds, array $groupIds, \Carbon\CarbonInterface $from, \Carbon\CarbonInterface $to)
 * @method static \Illuminate\Support\Collection stops(array $deviceIds, array $groupIds, \Carbon\CarbonInterface $from, \Carbon\CarbonInterface $to)
 *
 * @see \ThingsTelemetry\Traccar\Endpoints\Report
 */
class Report extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Report::class;
    }
}
