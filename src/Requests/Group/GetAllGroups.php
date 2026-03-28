<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Group;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\GroupData;

class GetAllGroups extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public ?bool $all = null,
        public ?int $userId = null,
        public ?bool $excludeAttributes = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/groups';
    }

    /** @return Collection<int, GroupData> */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect(value: $response->json())
            ->map(callback: fn ($group) => GroupData::fromArray(data: $group));
    }

    /** @return array<string, bool|int|string> */
    protected function defaultQuery(): array
    {
        return array_filter([
            'all'               => $this->all,
            'userId'            => $this->userId,
            'excludeAttributes' => $this->excludeAttributes,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
