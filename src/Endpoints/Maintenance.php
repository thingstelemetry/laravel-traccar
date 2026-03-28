<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Dto\MaintenanceData;
use ThingsTelemetry\Traccar\Requests\Maintenance\CreateMaintenance;
use ThingsTelemetry\Traccar\Requests\Maintenance\DeleteMaintenance;
use ThingsTelemetry\Traccar\Requests\Maintenance\GetAllMaintenance;
use ThingsTelemetry\Traccar\Requests\Maintenance\UpdateMaintenance;

class Maintenance extends Traccar
{
    /** @throws \Saloon\Exceptions\SaloonException */
    public function getAll(?bool $all = null, ?int $userId = null, ?int $deviceId = null, ?int $groupId = null, ?bool $refresh = null, ?int $limit = null, ?int $offset = null, ?string $keyword = null): Collection
    {
        $response = $this->connector->send(
            request: new GetAllMaintenance(
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
    public function create(MaintenanceData $data): MaintenanceData
    {
        return $this->connector->send(request: new CreateMaintenance(data: $data))->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function update(MaintenanceData $data): MaintenanceData
    {
        return $this->connector->send(request: new UpdateMaintenance(data: $data))->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function delete(int $id): StatusData
    {
        return $this->connector->send(request: new DeleteMaintenance(id: $id))->dtoOrFail();
    }
}
