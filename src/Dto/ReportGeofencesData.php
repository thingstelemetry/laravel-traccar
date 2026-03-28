<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

use Throwable;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Log;

class ReportGeofencesData
{
    public function __construct(
        public int $deviceId,
        public string $deviceName,
        public int $geofenceId,
        public CarbonImmutable $startTime,
        public CarbonImmutable $endTime,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            deviceId: (int) ($data['deviceId'] ?? 0),
            deviceName: (string) ($data['deviceName'] ?? ''),
            geofenceId: (int) ($data['geofenceId'] ?? 0),
            startTime: self::parseTime(raw: $data['startTime'] ?? null, field: 'startTime'),
            endTime: self::parseTime(raw: $data['endTime'] ?? null, field: 'endTime'),
        );
    }

    private static function parseTime(mixed $raw, string $field): CarbonImmutable
    {
        if (is_string($raw) && $raw !== '') {
            try {
                return CarbonImmutable::parse($raw);
            } catch (Throwable $e) {
                Log::info("Failed to parse ReportGeofences {$field}: ".$e->getMessage());
            }
        }

        return CarbonImmutable::now();
    }
}
