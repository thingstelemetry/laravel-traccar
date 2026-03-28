<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Geofence;

use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Dto\GeofenceData;
use ThingsTelemetry\Traccar\Requests\Abstract\CreateRequest;

class CreateGeofence extends CreateRequest
{
    public function __construct(public GeofenceData $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/geofences';
    }

    public function createDtoFromResponse(Response $response): GeofenceData
    {
        return GeofenceData::fromArray(data: $response->json());
    }
}
