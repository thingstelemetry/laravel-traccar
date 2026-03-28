<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Attribute;

use Saloon\Http\Response;
use InvalidArgumentException;
use ThingsTelemetry\Traccar\Dto\AttributeData;
use ThingsTelemetry\Traccar\Requests\Abstract\UpdateRequest;

class UpdateAttribute extends UpdateRequest
{
    public function __construct(public AttributeData $data)
    {
        if (is_null($data->id)) {
            throw new InvalidArgumentException(message: 'Attribute ID is required for update operations.');
        }
    }

    public function resolveEndpoint(): string
    {
        return "/attributes/computed/{$this->data->id}";
    }

    public function createDtoFromResponse(Response $response): AttributeData
    {
        return AttributeData::fromArray(data: $response->json());
    }
}
