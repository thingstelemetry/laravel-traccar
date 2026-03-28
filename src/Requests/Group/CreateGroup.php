<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Group;

use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Dto\GroupData;
use ThingsTelemetry\Traccar\Requests\Abstract\CreateRequest;

class CreateGroup extends CreateRequest
{
    public function __construct(public GroupData $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/groups';
    }

    public function createDtoFromResponse(Response $response): GroupData
    {
        return GroupData::fromArray(data: $response->json());
    }
}
