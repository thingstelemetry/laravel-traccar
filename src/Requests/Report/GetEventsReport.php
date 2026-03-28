<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Report;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\EventData;

class GetEventsReport extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array<int>  $deviceIds
     * @param  array<int>  $groupIds
     * @param  array<string>|null  $types
     * @param  array<string>|null  $alarms
     */
    public function __construct(
        public array $deviceIds,
        public array $groupIds,
        public CarbonImmutable $from,
        public CarbonImmutable $to,
        public ?array $types = null,
        public ?array $alarms = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/reports/events';
    }

    /** @return Collection<int, EventData> */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect(value: $response->json())
            ->map(callback: fn (array $event) => EventData::fromArray(data: $event));
    }

    /** @return array<string, mixed> */
    protected function defaultQuery(): array
    {
        return array_filter([
            'deviceId' => $this->deviceIds,
            'groupId'  => $this->groupIds,
            'type'     => $this->types,
            'alarm'    => $this->alarms,
            'from'     => $this->from->toIso8601String(),
            'to'       => $this->to->toIso8601String(),
        ], static fn (mixed $value): bool => $value !== null && $value !== []);
    }
}
