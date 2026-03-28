<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Facade;
use ThingsTelemetry\Traccar\Dto\GroupShareData;
use ThingsTelemetry\Traccar\Dto\DeviceShareData;

/**
 * @method static DeviceShareData device(int $deviceId, CarbonInterface $expiration)
 * @method static GroupShareData group(int $groupId, CarbonInterface $expiration)
 */
class Share extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Share::class;
    }
}
