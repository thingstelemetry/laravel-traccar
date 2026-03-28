<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Order;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\OrderData;

class GetAllOrders extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public ?bool $all = null,
        public ?int $userId = null,
        public ?bool $excludeAttributes = null,
        public ?int $limit = null,
        public ?int $offset = null,
        public ?string $keyword = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/orders';
    }

    /** @return Collection<int, OrderData> */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect(value: $response->json())
            ->map(callback: fn (array $order) => OrderData::fromArray(data: $order));
    }

    /** @return array<string, bool|int|string> */
    protected function defaultQuery(): array
    {
        return array_filter([
            'all'               => $this->all,
            'userId'            => $this->userId,
            'excludeAttributes' => $this->excludeAttributes,
            'limit'             => $this->limit,
            'offset'            => $this->offset,
            'keyword'           => $this->keyword,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
