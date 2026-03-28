<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Facade;
use ThingsTelemetry\Traccar\Dto\UserData;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Dto\SessionTokenData;

/**
 * @method static UserData current(string|null $token = null)
 * @method static UserData forUser(int $userId)
 * @method static UserData create(string $email, string $password, int|null $code = null)
 * @method static StatusData delete()
 * @method static SessionTokenData generateToken(CarbonInterface|null $expiration = null)
 * @method static StatusData revokeToken(string $token)
 * @method static string getOpenIdAuthUrl()
 * @method static string handleOpenIdCallback(string $queryString)
 */
class Session extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Session::class;
    }
}
