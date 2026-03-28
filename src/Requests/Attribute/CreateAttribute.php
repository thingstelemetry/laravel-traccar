<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Attribute;

use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Dto\AttributeData;
use ThingsTelemetry\Traccar\Requests\Abstract\CreateRequest;

class CreateAttribute extends CreateRequest
{
    public function __construct(public AttributeData $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/attributes/computed';
    }

    public function createDtoFromResponse(Response $response): AttributeData
    {
        return AttributeData::fromArray(data: $response->json());
    }
}
