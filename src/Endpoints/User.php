<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Dto\UserData;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Requests\User\GetUser;
use ThingsTelemetry\Traccar\Requests\User\CreateUser;
use ThingsTelemetry\Traccar\Requests\User\DeleteUser;
use ThingsTelemetry\Traccar\Requests\User\UpdateUser;
use ThingsTelemetry\Traccar\Requests\User\GetAllUsers;
use ThingsTelemetry\Traccar\Requests\User\GenerateTotpSecret;

class User extends Traccar
{
    /** @throws \Saloon\Exceptions\SaloonException */
    public function get(int $id): UserData
    {
        $response = $this->connector->send(request: new GetUser(id: $id));

        return $response->dtoOrFail();
    }

    /**
     * @deprecated Use get(int $id) instead.
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function find(int $id): UserData
    {
        trigger_error(message: 'User::find() is deprecated. Use User::get() instead.', error_level: E_USER_DEPRECATED);

        return $this->get(id: $id);
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function all(
        ?int $userId = null,
        ?int $deviceId = null,
        ?bool $excludeAttributes = null,
        ?int $limit = null,
        ?int $offset = null,
        ?string $keyword = null,
    ): Collection {
        $response = $this->connector->send(
            request: new GetAllUsers(
                userId: $userId,
                deviceId: $deviceId,
                excludeAttributes: $excludeAttributes,
                limit: $limit,
                offset: $offset,
                keyword: $keyword,
            )
        );

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

    /** @throws \Saloon\Exceptions\SaloonException */
    public function generateTotpSecret(): string
    {
        $response = $this->connector->send(request: new GenerateTotpSecret());

        return $response->dtoOrFail();
    }
}
