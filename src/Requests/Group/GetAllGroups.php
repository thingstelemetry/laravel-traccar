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
        $query = $this->buildQuery();

        return '/groups'.($query ? "?{$query}" : '');
    }

    /** @return Collection<int, GroupData> */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect(value: $response->json())
            ->map(callback: fn ($group) => GroupData::fromArray(data: $group));
    }

    private function buildQuery(): string
    {
        $params = [];

        if ($this->all !== null) {
            $params[] = 'all='.($this->all ? 'true' : 'false');
        }

        if ($this->userId !== null) {
            $params[] = "userId={$this->userId}";
        }

        if ($this->excludeAttributes !== null) {
            $params[] = 'excludeAttributes='.($this->excludeAttributes ? 'true' : 'false');
        }

        return implode('&', $params);
    }
}
