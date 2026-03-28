<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Dto\PositionData;

/**
 * @method static Collection<int, PositionData> get(?int $deviceId = null, CarbonInterface|null $from = null, CarbonInterface|null $to = null, ?array $ids = null)
 * @method static StatusData delete(int $id)
 * @method static StatusData deleteForDeviceInRange(int $deviceId, CarbonInterface $from, CarbonInterface $to)
 * @method static string exportKml(int $deviceId, CarbonInterface $from, CarbonInterface $to)
 * @method static string exportCsv(int $deviceId, CarbonInterface $from, CarbonInterface $to, ?int $geofenceId = null)
 * @method static string exportGpx(int $deviceId, CarbonInterface $from, CarbonInterface $to)
 */
class Position extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Position::class;
    }
}
