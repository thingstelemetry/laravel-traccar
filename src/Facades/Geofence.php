<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection all(?bool $all = null, ?int $userId = null, ?int $deviceId = null, ?int $groupId = null, ?bool $refresh = null, ?int $limit = null, ?int $offset = null, ?string $keyword = null)
 * @method static \ThingsTelemetry\Traccar\Dto\GeofenceData create(\ThingsTelemetry\Traccar\Dto\GeofenceData $data)
 * @method static \ThingsTelemetry\Traccar\Dto\GeofenceData update(\ThingsTelemetry\Traccar\Dto\GeofenceData $data)
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData delete(int $id)
 *
 * @see \ThingsTelemetry\Traccar\Endpoints\Geofence
 */
class Geofence extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Geofence::class;
    }
}
