<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \ThingsTelemetry\Traccar\Dto\DeviceShareData device(int $deviceId, \Carbon\CarbonInterface $expiration)
 * @method static \ThingsTelemetry\Traccar\Dto\GroupShareData group(int $groupId, \Carbon\CarbonInterface $expiration)
 *
 * @see \ThingsTelemetry\Traccar\Endpoints\Share
 */
class Share extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Share::class;
    }
}
