<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData reset(string $email)
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData update(string $token, string $password)
 *
 * @see \ThingsTelemetry\Traccar\Endpoints\Password
 */
class Password extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Password::class;
    }
}
