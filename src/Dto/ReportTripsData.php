<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

use Throwable;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Log;

class ReportTripsData
{
    public function __construct(
        public int $deviceId,
        public string $deviceName,
        public float $maxSpeed,
        public float $averageSpeed,
        public float $distance,
        public float $spentFuel,
        public int $duration,
        public CarbonImmutable $startTime,
        public string $startAddress,
        public float $startLat,
        public float $startLon,
        public CarbonImmutable $endTime,
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
            startTime: self::parseTime(raw: $data['startTime'] ?? null, field: 'startTime'),
            startAddress: (string) ($data['startAddress'] ?? ''),
            startLat: (float) ($data['startLat'] ?? 0),
            startLon: (float) ($data['startLon'] ?? 0),
            endTime: self::parseTime(raw: $data['endTime'] ?? null, field: 'endTime'),
            endAddress: (string) ($data['endAddress'] ?? ''),
            endLat: (float) ($data['endLat'] ?? 0),
            endLon: (float) ($data['endLon'] ?? 0),
            driverUniqueId: (string) ($data['driverUniqueId'] ?? ''),
            driverName: (string) ($data['driverName'] ?? ''),
        );
    }

    private static function parseTime(mixed $raw, string $field): CarbonImmutable
    {
        if (is_string($raw) && $raw !== '') {
            try {
                return CarbonImmutable::parse($raw);
            } catch (Throwable $e) {
                Log::info("Failed to parse ReportTrips {$field}: ".$e->getMessage());
            }
        }

        return CarbonImmutable::now();
    }
}
