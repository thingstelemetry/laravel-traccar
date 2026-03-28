<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Maintenance;

use Saloon\Http\Response;
use InvalidArgumentException;
use ThingsTelemetry\Traccar\Dto\MaintenanceData;
use ThingsTelemetry\Traccar\Requests\Abstract\UpdateRequest;

class UpdateMaintenance extends UpdateRequest
{
    public function __construct(public MaintenanceData $data)
    {
        if ($data->id <= 0) {
            throw new InvalidArgumentException(message: 'Maintenance ID is required for update operations.');
        }
    }

    public function resolveEndpoint(): string
    {
        return "/maintenance/{$this->data->id}";
    }

    public function createDtoFromResponse(Response $response): MaintenanceData
    {
        return MaintenanceData::fromArray(data: $response->json());
    }
}
