<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection getAll()
 * @method static \ThingsTelemetry\Traccar\Dto\DeviceData find(int $id)
 * @method static \Illuminate\Support\Collection get(?int $userId = null, ?array $ids = null, ?array $uniqueIds = null)
 * @method static \ThingsTelemetry\Traccar\Dto\DeviceData create(\ThingsTelemetry\Traccar\Dto\DeviceData $data)
 * @method static \ThingsTelemetry\Traccar\Dto\DeviceData update(\ThingsTelemetry\Traccar\Dto\DeviceData $data)
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData updateTotals(int $deviceId, float $totalDistance, float $hours)
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData delete(int $id)
 * @method static string updateImage(int $deviceId, \Illuminate\Http\UploadedFile|\Symfony\Component\HttpFoundation\File\File|string $file)
 *
 * @see \ThingsTelemetry\Traccar\Endpoints\Device
 */
class Device extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Device::class;
    }
}
