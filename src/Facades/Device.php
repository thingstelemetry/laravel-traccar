<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Carbon\CarbonInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use ThingsTelemetry\Traccar\Dto\DeviceData;
use ThingsTelemetry\Traccar\Dto\StatusData;
use Symfony\Component\HttpFoundation\File\File;
use ThingsTelemetry\Traccar\Dto\DeviceShareData;

/**
 * @method static Collection getAll()
 * @method static DeviceData find(int $id)
 * @method static Collection get(?int $userId = null, ?array $ids = null, ?array $uniqueIds = null)
 * @method static DeviceData create(DeviceData $data)
 * @method static DeviceData update(DeviceData $data)
 * @method static StatusData updateTotals(int $deviceId, float $totalDistance, float $hours)
 * @method static StatusData delete(int $id)
 * @method static string updateImage(int $deviceId, UploadedFile|File|string $file)
 * @method static DeviceShareData share(int $deviceId, CarbonInterface $expiration)
 */
class Device extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Device::class;
    }
}
