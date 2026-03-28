<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Attribute;

use Saloon\Http\Response;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\AttributeData;
use ThingsTelemetry\Traccar\Requests\Abstract\GetAllRequest;

class GetAllAttributes extends GetAllRequest
{
    public function resolveEndpoint(): string
    {
        return '/attributes/computed';
    }

    /** @return Collection<int, AttributeData> */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect(value: $response->json())
            ->map(callback: fn (array $attribute) => AttributeData::fromArray(data: $attribute));
    }
}
