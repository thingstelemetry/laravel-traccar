<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Support\DataHelper;
use ThingsTelemetry\Traccar\Support\ParsesTimestamps;

class EventData
{
    use ParsesTimestamps;
    public function __construct(
        public int $id,
        public string $type,
        public ?CarbonImmutable $eventTime,
        public int $deviceId,
        public ?int $positionId = null,
        public ?int $geofenceId = null,
        public ?int $maintenanceId = null,
        /** @var array<string, mixed> */
        public array $attributes = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            type: (string) ($data['type'] ?? ''),
            eventTime: self::parseTimestamp(raw: $data['eventTime'] ?? null, field: 'eventTime'),
            deviceId: (int) ($data['deviceId'] ?? 0),
            positionId: DataHelper::nullableInt(data: $data, key: 'positionId'),
            geofenceId: DataHelper::nullableInt(data: $data, key: 'geofenceId'),
            maintenanceId: DataHelper::nullableInt(data: $data, key: 'maintenanceId'),
            attributes: is_array($data['attributes'] ?? null) ? $data['attributes'] : [],
        );
    }

    public function toArray(): array
    {
        return [
            'id'            => $this->id,
            'type'          => $this->type,
            'eventTime'     => $this->eventTime?->toIso8601String(),
            'deviceId'      => $this->deviceId,
            'positionId'    => $this->positionId,
            'geofenceId'    => $this->geofenceId,
            'maintenanceId' => $this->maintenanceId,
            'attributes'    => $this->attributes,
        ];
    }
}
