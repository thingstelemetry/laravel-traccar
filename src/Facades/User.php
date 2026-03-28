<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use ThingsTelemetry\Traccar\Dto\UserData;
use ThingsTelemetry\Traccar\Dto\StatusData;

/**
 * @method static UserData get(int $id)
 * @method static Collection<UserData> all(?int $userId = null, ?int $deviceId = null, ?bool $excludeAttributes = null, ?int $limit = null, ?int $offset = null, ?string $keyword = null)
 * @method static UserData create(UserData $data)
 * @method static UserData update(UserData $data)
 * @method static StatusData delete(int $id)
 * @method static string generateTotpSecret()
 */
class User extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\User::class;
    }
}
