<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Driver;

use Saloon\Http\Response;
use InvalidArgumentException;
use ThingsTelemetry\Traccar\Dto\DriverData;
use ThingsTelemetry\Traccar\Requests\Abstract\UpdateRequest;

class UpdateDriver extends UpdateRequest
{
    public function __construct(public DriverData $data)
    {
        if ($data->id <= 0) {
            throw new InvalidArgumentException(message: 'Driver ID is required for update operations.');
        }
    }

    public function resolveEndpoint(): string
    {
        return "/drivers/{$this->data->id}";
    }

    public function createDtoFromResponse(Response $response): DriverData
    {
        return DriverData::fromArray(data: $response->json());
    }
}
