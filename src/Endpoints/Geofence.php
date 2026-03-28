<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Dto\GeofenceData;
use ThingsTelemetry\Traccar\Requests\Geofence\CreateGeofence;
use ThingsTelemetry\Traccar\Requests\Geofence\DeleteGeofence;
use ThingsTelemetry\Traccar\Requests\Geofence\UpdateGeofence;
use ThingsTelemetry\Traccar\Requests\Geofence\GetAllGeofences;

class Geofence extends Traccar
{
    /** @throws \Saloon\Exceptions\SaloonException */
    public function all(?bool $all = null, ?int $userId = null, ?int $deviceId = null, ?int $groupId = null, ?bool $refresh = null, ?int $limit = null, ?int $offset = null, ?string $keyword = null): Collection
    {
        $response = $this->connector->send(
            request: new GetAllGeofences(
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
    public function create(GeofenceData $data): GeofenceData
    {
        return $this->connector->send(request: new CreateGeofence(data: $data))->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function update(GeofenceData $data): GeofenceData
    {
        return $this->connector->send(request: new UpdateGeofence(data: $data))->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function delete(int $id): StatusData
    {
        return $this->connector->send(request: new DeleteGeofence(id: $id))->dtoOrFail();
    }
}
