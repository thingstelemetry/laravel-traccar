<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Endpoints;

use TrackTelemetry\Traccar\Traccar;
use TrackTelemetry\Traccar\Dto\ServerData;
use TrackTelemetry\Traccar\Requests\GetServerInformation;

class Server extends Traccar
{
    /**
     * Get server information
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function getInformation(): ServerData
    {
        $response = $this->connector->send(
            request: new GetServerInformation()
        );

        return $response->dtoOrFail();
    }

    // Update server information
}
