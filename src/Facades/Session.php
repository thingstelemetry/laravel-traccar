<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ThingsTelemetry\Traccar\Endpoints\Session
 *
 * @method static \ThingsTelemetry\Traccar\Dto\UserData get(string|null $token = null)
 * @method static \ThingsTelemetry\Traccar\Dto\UserData getById(int $userId)
 * @method static \ThingsTelemetry\Traccar\Dto\UserData create(string $email, string $password, int|null $code = null)
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData delete()
 * @method static \ThingsTelemetry\Traccar\Dto\SessionTokenData generateToken(\Carbon\CarbonInterface|null $expiration = null)
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData revokeToken(string $token)
 * @method static string getOpenIdAuthUrl()
 * @method static string handleOpenIdCallback(string $queryString)
 */
class Session extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Session::class;
    }
}
