<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use ThingsTelemetry\Traccar\Dto\DeviceData;
use ThingsTelemetry\Traccar\Dto\StatusData;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @method static Collection all(?int $userId = null, ?array $ids = null, ?array $uniqueIds = null, ?bool $all = null, ?bool $excludeAttributes = null, ?int $limit = null, ?int $offset = null, ?string $keyword = null)
 * @method static DeviceData find(int $id)
 * @method static DeviceData create(DeviceData $data)
 * @method static DeviceData update(DeviceData $data)
 * @method static StatusData updateTotals(int $deviceId, float $totalDistance, float $hours)
 * @method static StatusData delete(int $id)
 * @method static string updateImage(int $deviceId, UploadedFile|File|string $file)
 */
class Device extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Device::class;
    }
}
