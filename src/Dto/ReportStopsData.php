<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Support\ParsesTimestamps;

class ReportStopsData
{
    use ParsesTimestamps;
    public function __construct(
        public int $deviceId,
        public string $deviceName,
        public int $duration,
        public ?CarbonImmutable $startTime,
        public string $address,
        public float $lat,
        public float $lon,
        public ?CarbonImmutable $endTime,
        public float $spentFuel,
        public int $engineHours,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            deviceId: (int) ($data['deviceId'] ?? 0),
            deviceName: (string) ($data['deviceName'] ?? ''),
            duration: (int) ($data['duration'] ?? 0),
            startTime: self::parseTimestamp(raw: $data['startTime'] ?? null, field: 'startTime'),
            address: (string) ($data['address'] ?? ''),
            lat: (float) ($data['lat'] ?? 0),
            lon: (float) ($data['lon'] ?? 0),
            endTime: self::parseTimestamp(raw: $data['endTime'] ?? null, field: 'endTime'),
            spentFuel: (float) ($data['spentFuel'] ?? 0),
            engineHours: (int) ($data['engineHours'] ?? 0),
        );
    }

    public function toArray(): array
    {
        return [
            'deviceId'    => $this->deviceId,
            'deviceName'  => $this->deviceName,
            'duration'    => $this->duration,
            'startTime'   => $this->startTime?->toIso8601String(),
            'address'     => $this->address,
            'lat'         => $this->lat,
            'lon'         => $this->lon,
            'endTime'     => $this->endTime?->toIso8601String(),
            'spentFuel'   => $this->spentFuel,
            'engineHours' => $this->engineHours,
        ];
    }
}
