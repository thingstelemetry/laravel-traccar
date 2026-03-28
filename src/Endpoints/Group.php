<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Dto\GroupData;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Requests\Group\GetGroup;
use ThingsTelemetry\Traccar\Requests\Group\CreateGroup;
use ThingsTelemetry\Traccar\Requests\Group\DeleteGroup;
use ThingsTelemetry\Traccar\Requests\Group\UpdateGroup;
use ThingsTelemetry\Traccar\Requests\Group\GetAllGroups;

class Group extends Traccar
{
    /** @throws \Saloon\Exceptions\SaloonException */
    public function all(?bool $all = null, ?int $userId = null, ?bool $excludeAttributes = null): Collection
    {
        $response = $this->connector->send(
            request: new GetAllGroups(
                all: $all,
                userId: $userId,
                excludeAttributes: $excludeAttributes
            )
        );

        return $response->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function find(int $id): GroupData
    {
        $response = $this->connector->send(request: new GetGroup(id: $id));

        return $response->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function create(GroupData $data): GroupData
    {
        $response = $this->connector->send(request: new CreateGroup(data: $data));

        return $response->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function update(GroupData $data): GroupData
    {
        $response = $this->connector->send(request: new UpdateGroup(data: $data));

        return $response->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function delete(int $id): StatusData
    {
        $response = $this->connector->send(request: new DeleteGroup(id: $id));

        return $response->dtoOrFail();
    }
}
