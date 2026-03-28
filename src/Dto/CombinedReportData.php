<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

use Illuminate\Support\Collection;

class CombinedReportData
{
    /**
     * @param  Collection<int, PositionData>  $route
     * @param  Collection<int, EventData>  $events
     */
    public function __construct(
        public int $deviceId,
        public Collection $route,
        public Collection $events,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            deviceId: (int) ($data['deviceId'] ?? 0),
            route: collect(value: $data['route'] ?? [])
                ->map(callback: fn (array $position) => PositionData::fromArray(data: $position)),
            events: collect(value: $data['events'] ?? [])
                ->map(callback: fn (array $event) => EventData::fromArray(data: $event)),
        );
    }

    public function toArray(): array
    {
        return [
            'deviceId' => $this->deviceId,
            'route'    => $this->route->map(callback: fn (PositionData $position) => $position->toArray())->toArray(),
            'events'   => $this->events->map(callback: fn (EventData $event) => $event->toArray())->toArray(),
        ];
    }
}
