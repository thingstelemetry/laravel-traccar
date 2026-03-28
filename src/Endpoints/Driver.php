<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Dto\DriverData;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Requests\Driver\CreateDriver;
use ThingsTelemetry\Traccar\Requests\Driver\DeleteDriver;
use ThingsTelemetry\Traccar\Requests\Driver\UpdateDriver;
use ThingsTelemetry\Traccar\Requests\Driver\GetAllDrivers;

class Driver extends Traccar
{
    /** @throws \Saloon\Exceptions\SaloonException */
    public function getAll(?bool $all = null, ?int $userId = null, ?int $deviceId = null, ?int $groupId = null, ?bool $refresh = null, ?int $limit = null, ?int $offset = null, ?string $keyword = null): Collection
    {
        $response = $this->connector->send(
            request: new GetAllDrivers(
                all: $all,
                userId: $userId,
                deviceId: $deviceId,
                groupId: $groupId,
                refresh: $refresh,
                limit: $limit,
                offset: $offset,
                keyword: $keyword,
            )
        );

        return $response->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function create(DriverData $data): DriverData
    {
        return $this->connector->send(request: new CreateDriver(data: $data))->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function update(DriverData $data): DriverData
    {
        return $this->connector->send(request: new UpdateDriver(data: $data))->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function delete(int $id): StatusData
    {
        return $this->connector->send(request: new DeleteDriver(id: $id))->dtoOrFail();
    }
}
