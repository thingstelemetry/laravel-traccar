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
        return array_filter(array: [
            'userId'            => $this->userId,
            'id'                => $this->ids,
            'uniqueId'          => $this->uniqueIds,
            'all'               => $this->all,
            'excludeAttributes' => $this->excludeAttributes,
            'limit'             => $this->limit,
            'offset'            => $this->offset,
            'keyword'           => $this->keyword,
        ], callback: static fn (mixed $value): bool => $value !== null);
    }
}
