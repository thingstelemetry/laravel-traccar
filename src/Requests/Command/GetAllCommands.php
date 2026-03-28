<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Command;

use Saloon\Http\Response;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\CommandData;
use ThingsTelemetry\Traccar\Requests\Abstract\GetAllRequest;

class GetAllCommands extends GetAllRequest
{
    public function resolveEndpoint(): string
    {
        return '/commands';
    }

    /** @return Collection<int, CommandData> */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect(value: $response->json())
            ->map(callback: fn (array $command) => CommandData::fromArray(data: $command));
    }
}
