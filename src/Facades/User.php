<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \TrackTelemetry\Traccar\Dto\UserData get(int $id)
 * @method static array<int, \TrackTelemetry\Traccar\Dto\UserData> all()
 * @method static \TrackTelemetry\Traccar\Dto\UserData create(\TrackTelemetry\Traccar\Dto\UserData $data)
 * @method static \TrackTelemetry\Traccar\Dto\UserData update(\TrackTelemetry\Traccar\Dto\UserData $data)
 * @method static \TrackTelemetry\Traccar\Dto\StatusData delete(int $id)
 *
 * @see \TrackTelemetry\Traccar\Endpoints\User
 */
class User extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \TrackTelemetry\Traccar\Endpoints\User::class;
    }
}
