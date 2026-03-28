<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Command;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\CommandData;

class GetSendableCommands extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public int $deviceId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/commands/send';
    }

    /** @return Collection<int, CommandData> */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect(value: $response->json())
            ->map(callback: fn (array $command) => CommandData::fromArray(data: $command));
    }

    /** @return array<string, int> */
    protected function defaultQuery(): array
    {
        return [
            'deviceId' => $this->deviceId,
        ];
    }
}
