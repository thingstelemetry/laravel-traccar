<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Geofence;

use Saloon\Http\Response;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\GeofenceData;
use ThingsTelemetry\Traccar\Requests\Abstract\GetAllRequest;

class GetAllGeofences extends GetAllRequest
{
    public function resolveEndpoint(): string
    {
        return '/geofences';
    }

    /** @return Collection<int, GeofenceData> */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect(value: $response->json())
            ->map(callback: fn (array $geofence) => GeofenceData::fromArray(data: $geofence));
    }
}
