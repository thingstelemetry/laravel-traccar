<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection getAll(?bool $all = null, ?int $userId = null, ?int $deviceId = null, ?int $groupId = null, ?bool $refresh = null, ?int $limit = null, ?int $offset = null, ?string $keyword = null)
 * @method static \ThingsTelemetry\Traccar\Dto\MaintenanceData create(\ThingsTelemetry\Traccar\Dto\MaintenanceData $data)
 * @method static \ThingsTelemetry\Traccar\Dto\MaintenanceData update(\ThingsTelemetry\Traccar\Dto\MaintenanceData $data)
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData delete(int $id)
 *
 * @see \ThingsTelemetry\Traccar\Endpoints\Maintenance
 */
class Maintenance extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Maintenance::class;
    }
}
