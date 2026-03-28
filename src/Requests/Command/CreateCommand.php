<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Command;

use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Dto\CommandData;
use ThingsTelemetry\Traccar\Requests\Abstract\CreateRequest;

class CreateCommand extends CreateRequest
{
    public function __construct(public CommandData $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/commands';
    }

    public function createDtoFromResponse(Response $response): CommandData
    {
        return CommandData::fromArray(data: $response->json());
    }
}
