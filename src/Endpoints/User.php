<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Endpoints;

use TrackTelemetry\Traccar\Traccar;
use TrackTelemetry\Traccar\Dto\UserData;
use TrackTelemetry\Traccar\Requests\GetUser;

class User extends Traccar
{
    /**
     * Retrieve a user by ID.
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function get(int $id): UserData
    {
        $response = $this->connector->send(request: new GetUser(id: $id));

        return $response->dtoOrFail();
    }
}
