<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Device;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\DeviceData;

class GetAllDevices extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array<int, int>|null  $ids
     * @param  array<int, string>|null  $uniqueIds
     */
    public function __construct(
        public ?int $userId = null,
        public ?array $ids = null,
        public ?array $uniqueIds = null,
        public ?bool $all = null,
        public ?bool $excludeAttributes = null,
        public ?int $limit = null,
        public ?int $offset = null,
        public ?string $keyword = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/devices';
    }

    /**
     * @return Collection<int, DeviceData>
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect(value: $response->json())
            ->map(callback: fn ($device) => DeviceData::fromArray(data: (array) $device));
    }

    /** @return array<string, mixed> */
    protected function defaultQuery(): array
    {
        $query = [];

        if ($this->userId !== null) {
            $query['userId'] = $this->userId;
        }

        if ($this->ids !== null && $this->ids !== []) {
            $query['id'] = array_map(
                callback: static fn (int $id): int => $id,
                array: $this->ids,
            );
        }

        if ($this->uniqueIds !== null && $this->uniqueIds !== []) {
            $query['uniqueId'] = array_map(
                callback: static fn (string $id): string => $id,
                array: $this->uniqueIds,
            );
        }

        if ($this->all !== null) {
            $query['all'] = $this->all;
        }

        if ($this->excludeAttributes !== null) {
            $query['excludeAttributes'] = $this->excludeAttributes;
        }

        if ($this->limit !== null) {
            $query['limit'] = $this->limit;
        }

        if ($this->offset !== null) {
            $query['offset'] = $this->offset;
        }

        if ($this->keyword !== null) {
            $query['keyword'] = $this->keyword;
        }

        return $query;
    }
}
