<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TrackTelemetry\Traccar\Endpoints\Server
 */
class Server extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return \TrackTelemetry\Traccar\Endpoints\Server::class;
    }
}
