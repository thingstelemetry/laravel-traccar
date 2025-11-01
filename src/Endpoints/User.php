<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Endpoints;

use TrackTelemetry\Traccar\Traccar;
use TrackTelemetry\Traccar\Dto\UserData;
use TrackTelemetry\Traccar\Dto\StatusData;
use TrackTelemetry\Traccar\Requests\GetUser;
use TrackTelemetry\Traccar\Requests\CreateUser;
use TrackTelemetry\Traccar\Requests\DeleteUser;
use TrackTelemetry\Traccar\Requests\UpdateUser;
use TrackTelemetry\Traccar\Requests\GetAllUsers;

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

    /**
     * Get all users
     *
     * @return array<int, UserData>
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function all(): array
    {
        $response = $this->connector->send(request: new GetAllUsers());

        return $response->dtoOrFail();
    }

    /**
     * Create a new user.
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function create(UserData $data): UserData
    {
        $response = $this->connector->send(request: new CreateUser(data: $data));

        return $response->dtoOrFail();
    }

    /**
     * Update an existing user.
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function update(UserData $data): UserData
    {
        $response = $this->connector->send(request: new UpdateUser(data: $data));

        return $response->dtoOrFail();
    }

    /**
     * Delete a user by ID.
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function delete(int $id): StatusData
    {
        $response = $this->connector->send(request: new DeleteUser(id: $id));

        return $response->dtoOrFail();
    }
}
