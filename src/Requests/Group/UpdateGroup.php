<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Group;

use Saloon\Http\Response;
use InvalidArgumentException;
use ThingsTelemetry\Traccar\Dto\GroupData;
use ThingsTelemetry\Traccar\Requests\Abstract\UpdateRequest;

class UpdateGroup extends UpdateRequest
{
    public function __construct(public GroupData $data)
    {
        if ($data->id <= 0) {
            throw new InvalidArgumentException(message: 'Group ID is required for update operations.');
        }
    }

    public function resolveEndpoint(): string
    {
        return "/groups/{$this->data->id}";
    }

    public function createDtoFromResponse(Response $response): GroupData
    {
        return GroupData::fromArray(data: $response->json());
    }
}
