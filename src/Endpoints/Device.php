<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Endpoints;

use Illuminate\Support\Collection;
use TrackTelemetry\Traccar\Traccar;
use TrackTelemetry\Traccar\Requests\GetAllDevices;

class Device extends Traccar
{
    /**
     * Get server information
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function getAll(): Collection
    {
        $response = $this->connector->send(
            request: new GetAllDevices()
        );

        return $response->dtoOrFail();
    }

}
