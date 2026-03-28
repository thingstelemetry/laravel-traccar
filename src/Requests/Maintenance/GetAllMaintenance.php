<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Maintenance;

use Saloon\Http\Response;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\MaintenanceData;
use ThingsTelemetry\Traccar\Requests\Abstract\GetAllRequest;

class GetAllMaintenance extends GetAllRequest
{
    public function resolveEndpoint(): string
    {
        return '/maintenance';
    }

    /** @return Collection<int, MaintenanceData> */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect(value: $response->json())
            ->map(callback: fn (array $maintenance) => MaintenanceData::fromArray(data: $maintenance));
    }
}
