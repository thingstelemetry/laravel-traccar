<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Geofence;

use Saloon\Http\Response;
use InvalidArgumentException;
use ThingsTelemetry\Traccar\Dto\GeofenceData;
use ThingsTelemetry\Traccar\Requests\Abstract\UpdateRequest;

class UpdateGeofence extends UpdateRequest
{
    public function __construct(public GeofenceData $data)
    {
        if ($data->id <= 0) {
            throw new InvalidArgumentException(message: 'Geofence ID is required for update operations.');
        }
    }

    public function resolveEndpoint(): string
    {
        return "/geofences/{$this->data->id}";
    }

    public function createDtoFromResponse(Response $response): GeofenceData
    {
        return GeofenceData::fromArray(data: $response->json());
    }
}
