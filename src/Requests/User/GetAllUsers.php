<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\User;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\UserData;

class GetAllUsers extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public ?int $userId = null,
        public ?int $deviceId = null,
        public ?bool $excludeAttributes = null,
        public ?int $limit = null,
        public ?int $offset = null,
        public ?string $keyword = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/users';
    }

    /**
     * @return Collection<int, UserData>
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect($response->json())
            ->map(fn ($u) => UserData::fromArray(data: (array) $u));
    }

    /** @return array<string, bool|int|string> */
    protected function defaultQuery(): array
    {
        return array_filter([
            'userId'            => $this->userId,
            'deviceId'          => $this->deviceId,
            'excludeAttributes' => $this->excludeAttributes,
            'limit'             => $this->limit,
            'offset'            => $this->offset,
            'keyword'           => $this->keyword,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
