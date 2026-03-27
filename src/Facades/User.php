<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \ThingsTelemetry\Traccar\Dto\UserData get(int $id)
 * @method static array all()
 * @method static \ThingsTelemetry\Traccar\Dto\UserData create(\ThingsTelemetry\Traccar\Dto\UserData $data)
 * @method static \ThingsTelemetry\Traccar\Dto\UserData update(\ThingsTelemetry\Traccar\Dto\UserData $data)
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData delete(int $id)
 * @method static string generateTotpSecret()
 *
 * @see \ThingsTelemetry\Traccar\Endpoints\User
 */
class User extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\User::class;
    }
}
