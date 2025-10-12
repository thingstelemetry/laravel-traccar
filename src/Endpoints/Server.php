<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Endpoints;

use TrackTelemetry\Traccar\Traccar;
use TrackTelemetry\Traccar\Dto\ServerData;
use TrackTelemetry\Traccar\Dto\StatusData;
use TrackTelemetry\Traccar\Requests\RebootServer;
use TrackTelemetry\Traccar\Requests\GetServerInformation;
use TrackTelemetry\Traccar\Requests\UpdateServerInformation;

class Server extends Traccar
{
    /**
     * Get server information
     *
     * @throws \\Saloon\\Exceptions\\SaloonException
     */
    public function getInformation(): ServerData
    {
        $response = $this->connector->send(request: new GetServerInformation());

        return $response->dtoOrFail();
    }

    /**
     * Update server information
     *
     * @throws \\Saloon\\Exceptions\\SaloonException
     */
    public function updateInformation(ServerData $data): ServerData
    {
        $response = $this->connector->send(request: new UpdateServerInformation($data));

        return $response->dtoOrFail();
    }

    /**
     * Reboot the Traccar server.
     *
     * Note: This endpoint is restricted to admin users only on the Traccar server.
     *
     * @throws \\Saloon\\Exceptions\\SaloonException
     */
    public function reboot(): StatusData
    {
        $response = $this->connector->send(request: new RebootServer());

        return $response->dtoOrFail();
    }
}
