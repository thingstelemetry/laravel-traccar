<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Driver;

use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Dto\DriverData;
use ThingsTelemetry\Traccar\Requests\Abstract\CreateRequest;

class CreateDriver extends CreateRequest
{
    public function __construct(public DriverData $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/drivers';
    }

    public function createDtoFromResponse(Response $response): DriverData
    {
        return DriverData::fromArray(data: $response->json());
    }
}
