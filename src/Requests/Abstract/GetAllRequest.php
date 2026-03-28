<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Abstract;

use Saloon\Enums\Method;
use Saloon\Http\Request;

abstract class GetAllRequest extends Request
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
