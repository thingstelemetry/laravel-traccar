<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

use Throwable;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Log;

class ReportStopsData
{
    public function __construct(
        public int $deviceId,
        public string $deviceName,
        public int $duration,
        public CarbonImmutable $startTime,
        public string $address,
        public float $lat,
        public float $lon,
        public CarbonImmutable $endTime,
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
            startTime: self::parseTime(raw: $data['startTime'] ?? null, field: 'startTime'),
            address: (string) ($data['address'] ?? ''),
            lat: (float) ($data['lat'] ?? 0),
            lon: (float) ($data['lon'] ?? 0),
            endTime: self::parseTime(raw: $data['endTime'] ?? null, field: 'endTime'),
            spentFuel: (float) ($data['spentFuel'] ?? 0),
            engineHours: (int) ($data['engineHours'] ?? 0),
        );
    }

    private static function parseTime(mixed $raw, string $field): CarbonImmutable
    {
        if (is_string($raw) && $raw !== '') {
            try {
                return CarbonImmutable::parse($raw);
            } catch (Throwable $e) {
                Log::info("Failed to parse ReportStops {$field}: ".$e->getMessage());
            }
        }

        return CarbonImmutable::now();
    }
}
