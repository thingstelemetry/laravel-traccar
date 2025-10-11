<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Endpoints;

use Illuminate\Support\Collection;
use TrackTelemetry\Traccar\Requests\GetForUserDevices;
use TrackTelemetry\Traccar\Traccar;
use TrackTelemetry\Traccar\Requests\GetAllDevices;

class Device extends Traccar
{
    /**
     * Get all devices
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function getAll(): Collection
    {
        $response = $this->connector->send(request: new GetAllDevices());

        return $response->dtoOrFail();
    }

    /**
     * Get devices by id, unique id or user id
     * or returns a list of the user's devices
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function get(?int $userId = null, ?array $ids = null, ?array $uniqueIds = null): Collection
    {
        $response = $this->connector->send(
            request: new GetForUserDevices(
                userId: $userId,
                ids: $ids,
                uniqueIds: $uniqueIds
            )
        );

        return $response->dtoOrFail();
    }

}
