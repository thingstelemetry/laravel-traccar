<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Maintenance;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\MaintenanceData;

class GetAllMaintenance extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public ?bool $all = null,
        public ?int $userId = null,
        public ?int $deviceId = null,
        public ?int $groupId = null,
        public ?bool $refresh = null,
        public ?int $limit = null,
        public ?int $offset = null,
        public ?string $keyword = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/maintenance';
    }

    /** @return Collection<int, MaintenanceData> */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect(value: $response->json())
            ->map(callback: fn (array $maintenance) => MaintenanceData::fromArray(data: $maintenance));
    }

    /** @return array<string, bool|int|string> */
    protected function defaultQuery(): array
    {
        return array_filter([
            'all'      => $this->all,
            'userId'   => $this->userId,
            'deviceId' => $this->deviceId,
            'groupId'  => $this->groupId,
            'refresh'  => $this->refresh,
            'limit'    => $this->limit,
            'offset'   => $this->offset,
            'keyword'  => $this->keyword,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
