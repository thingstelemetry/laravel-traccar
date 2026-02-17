<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Dto\UserData;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Requests\GetUser;
use ThingsTelemetry\Traccar\Requests\CreateUser;
use ThingsTelemetry\Traccar\Requests\DeleteUser;
use ThingsTelemetry\Traccar\Requests\UpdateUser;
use ThingsTelemetry\Traccar\Requests\GetAllUsers;

class User extends Traccar
{
    /** @throws \Saloon\Exceptions\SaloonException */
    public function get(int $id): UserData
    {
        $response = $this->connector->send(request: new GetUser(id: $id));

        return $response->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function all(): array
    {
        $response = $this->connector->send(request: new GetAllUsers());

        return $response->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function create(UserData $data): UserData
    {
        $response = $this->connector->send(request: new CreateUser(data: $data));

        return $response->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function update(UserData $data): UserData
    {
        $response = $this->connector->send(request: new UpdateUser(data: $data));

        return $response->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function delete(int $id): StatusData
    {
        $response = $this->connector->send(request: new DeleteUser(id: $id));

        return $response->dtoOrFail();
    }
}
