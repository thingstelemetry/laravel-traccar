<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Command;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\CommandTypeData;

class GetCommandTypes extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public ?int $deviceId = null,
        public ?bool $textChannel = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/commands/types';
    }

    /** @return Collection<int, CommandTypeData> */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect(value: $response->json())
            ->map(callback: fn (array $type) => CommandTypeData::fromArray(data: $type));
    }

    /** @return array<string, int|bool> */
    protected function defaultQuery(): array
    {
        return array_filter([
            'deviceId'    => $this->deviceId,
            'textChannel' => $this->textChannel,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
