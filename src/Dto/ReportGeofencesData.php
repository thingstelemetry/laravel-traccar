<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Support\ParsesTimestamps;

class ReportGeofencesData
{
    use ParsesTimestamps;
    public function __construct(
        public int $deviceId,
        public string $deviceName,
        public int $geofenceId,
        public ?CarbonImmutable $startTime,
        public ?CarbonImmutable $endTime,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            deviceId: (int) ($data['deviceId'] ?? 0),
            deviceName: (string) ($data['deviceName'] ?? ''),
            geofenceId: (int) ($data['geofenceId'] ?? 0),
            startTime: self::parseTimestamp(raw: $data['startTime'] ?? null, field: 'startTime'),
            endTime: self::parseTimestamp(raw: $data['endTime'] ?? null, field: 'endTime'),
        );
    }

    public function toArray(): array
    {
        return [
            'deviceId'   => $this->deviceId,
            'deviceName' => $this->deviceName,
            'geofenceId' => $this->geofenceId,
            'startTime'  => $this->startTime?->toIso8601String(),
            'endTime'    => $this->endTime?->toIso8601String(),
        ];
    }
}
