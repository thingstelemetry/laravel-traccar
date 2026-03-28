<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Support\ParsesTimestamps;

class ReportTripsData
{
    use ParsesTimestamps;
    public function __construct(
        public int $deviceId,
        public string $deviceName,
        public float $maxSpeed,
        public float $averageSpeed,
        public float $distance,
        public float $spentFuel,
        public int $duration,
        public ?CarbonImmutable $startTime,
        public string $startAddress,
        public float $startLat,
        public float $startLon,
        public ?CarbonImmutable $endTime,
        public string $endAddress,
        public float $endLat,
        public float $endLon,
        public string $driverUniqueId,
        public string $driverName,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            deviceId: (int) ($data['deviceId'] ?? 0),
            deviceName: (string) ($data['deviceName'] ?? ''),
            maxSpeed: (float) ($data['maxSpeed'] ?? 0),
            averageSpeed: (float) ($data['averageSpeed'] ?? 0),
            distance: (float) ($data['distance'] ?? 0),
            spentFuel: (float) ($data['spentFuel'] ?? 0),
            duration: (int) ($data['duration'] ?? 0),
            startTime: self::parseTimestamp(raw: $data['startTime'] ?? null, field: 'startTime'),
            startAddress: (string) ($data['startAddress'] ?? ''),
            startLat: (float) ($data['startLat'] ?? 0),
            startLon: (float) ($data['startLon'] ?? 0),
            endTime: self::parseTimestamp(raw: $data['endTime'] ?? null, field: 'endTime'),
            endAddress: (string) ($data['endAddress'] ?? ''),
            endLat: (float) ($data['endLat'] ?? 0),
            endLon: (float) ($data['endLon'] ?? 0),
            driverUniqueId: (string) ($data['driverUniqueId'] ?? ''),
            driverName: (string) ($data['driverName'] ?? ''),
        );
    }

    public function toArray(): array
    {
        return [
            'deviceId'       => $this->deviceId,
            'deviceName'     => $this->deviceName,
            'maxSpeed'       => $this->maxSpeed,
            'averageSpeed'   => $this->averageSpeed,
            'distance'       => $this->distance,
            'spentFuel'      => $this->spentFuel,
            'duration'       => $this->duration,
            'startTime'      => $this->startTime?->toIso8601String(),
            'startAddress'   => $this->startAddress,
            'startLat'       => $this->startLat,
            'startLon'       => $this->startLon,
            'endTime'        => $this->endTime?->toIso8601String(),
            'endAddress'     => $this->endAddress,
            'endLat'         => $this->endLat,
            'endLon'         => $this->endLon,
            'driverUniqueId' => $this->driverUniqueId,
            'driverName'     => $this->driverName,
        ];
    }
}
