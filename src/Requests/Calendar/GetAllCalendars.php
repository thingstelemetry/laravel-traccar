<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Calendar;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\CalendarData;

class GetAllCalendars extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public ?bool $all = null,
        public ?int $userId = null,
        public ?int $limit = null,
        public ?int $offset = null,
        public ?string $keyword = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/calendars';
    }

    /** @return Collection<int, CalendarData> */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect(value: $response->json())
            ->map(callback: fn (array $calendar) => CalendarData::fromArray(data: $calendar));
    }

    /** @return array<string, bool|int|string> */
    protected function defaultQuery(): array
    {
        return array_filter([
            'all'     => $this->all,
            'userId'  => $this->userId,
            'limit'   => $this->limit,
            'offset'  => $this->offset,
            'keyword' => $this->keyword,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
