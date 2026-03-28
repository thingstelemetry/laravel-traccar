<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Driver;

use Saloon\Http\Response;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\DriverData;
use ThingsTelemetry\Traccar\Requests\Abstract\GetAllRequest;

class GetAllDrivers extends GetAllRequest
{
    public function resolveEndpoint(): string
    {
        return '/drivers';
    }

    /** @return Collection<int, DriverData> */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect(value: $response->json())
            ->map(callback: fn (array $driver) => DriverData::fromArray(data: $driver));
    }
}
