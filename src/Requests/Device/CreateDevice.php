<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Device;

use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Dto\DeviceData;
use ThingsTelemetry\Traccar\Requests\Abstract\CreateRequest;

class CreateDevice extends CreateRequest
{
    public function __construct(public DeviceData $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/devices';
    }

    public function createDtoFromResponse(Response $response): DeviceData
    {
        return DeviceData::fromArray(data: $response->json());
    }
}
