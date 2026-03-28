<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Device;

use Saloon\Http\Response;
use InvalidArgumentException;
use ThingsTelemetry\Traccar\Dto\DeviceData;
use ThingsTelemetry\Traccar\Requests\Abstract\UpdateRequest;

class UpdateDevice extends UpdateRequest
{
    public function __construct(public DeviceData $data)
    {
        if (is_null($data->id)) {
            throw new InvalidArgumentException(message: 'Device ID is required for update operations.');
        }
    }

    public function resolveEndpoint(): string
    {
        return "/devices/{$this->data->id}";
    }

    public function createDtoFromResponse(Response $response): DeviceData
    {
        return DeviceData::fromArray(data: $response->json());
    }
}
