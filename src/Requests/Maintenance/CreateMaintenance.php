<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Maintenance;

use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Dto\MaintenanceData;
use ThingsTelemetry\Traccar\Requests\Abstract\CreateRequest;

class CreateMaintenance extends CreateRequest
{
    public function __construct(public MaintenanceData $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/maintenance';
    }

    public function createDtoFromResponse(Response $response): MaintenanceData
    {
        return MaintenanceData::fromArray(data: $response->json());
    }
}
