<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

use Throwable;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Log;

class PositionData
{
    /**
     * @param array<int, int> $geofenceIds
     * @param array<string, mixed> $network
     * @param array<string, mixed> $attributes
     */
    public function __construct(
        public int $id,
        public int $deviceId,
        public string $protocol,
        public ?CarbonImmutable $deviceTime,
        public ?CarbonImmutable $fixTime,
        public ?CarbonImmutable $serverTime,
        public bool $valid,
        public float $latitude,
        public float $longitude,
        public float $altitude,
        public float $speed,
        public float $course,
        public string $address,
        public float $accuracy,
        public array $network,
        public array $geofenceIds,
        public array $attributes,
    ) {
    }

    public static function fromArray(array $data): self
    {
        $deviceTime = self::parseTime($data['deviceTime'] ?? null, 'deviceTime');
        $fixTime = self::parseTime($data['fixTime'] ?? null, 'fixTime');
        $serverTime = self::parseTime($data['serverTime'] ?? null, 'serverTime');

        $geofenceIds = [];
        if (is_array($data['geofenceIds'] ?? null)) {
            foreach ($data['geofenceIds'] as $id) {
                $geofenceIds[] = (int) $id;
            }
        }

        return new self(
            id: (int) ($data['id'] ?? 0),
            deviceId: (int) ($data['deviceId'] ?? 0),
            protocol: (string) ($data['protocol'] ?? ''),
            deviceTime: $deviceTime,
            fixTime: $fixTime,
            serverTime: $serverTime,
            valid: (bool) ($data['valid'] ?? false),
            latitude: (float) ($data['latitude'] ?? 0.0),
            longitude: (float) ($data['longitude'] ?? 0.0),
            altitude: (float) ($data['altitude'] ?? 0.0),
            speed: (float) ($data['speed'] ?? 0.0),
            course: (float) ($data['course'] ?? 0.0),
            address: (string) ($data['address'] ?? ''),
            accuracy: (float) ($data['accuracy'] ?? 0.0),
            network: is_array($data['network'] ?? null) ? $data['network'] : [],
            geofenceIds: $geofenceIds,
            attributes: is_array($data['attributes'] ?? null) ? $data['attributes'] : [],
        );
    }

    public function toArray(): array
    {
        return [
            'id'          => $this->id,
            'deviceId'    => $this->deviceId,
            'protocol'    => $this->protocol,
            'deviceTime'  => $this->deviceTime?->toIso8601String(),
            'fixTime'     => $this->fixTime?->toIso8601String(),
            'serverTime'  => $this->serverTime?->toIso8601String(),
            'valid'       => $this->valid,
            'latitude'    => $this->latitude,
            'longitude'   => $this->longitude,
            'altitude'    => $this->altitude,
            'speed'       => $this->speed,
            'course'      => $this->course,
            'address'     => $this->address,
            'accuracy'    => $this->accuracy,
            'network'     => $this->network,
            'geofenceIds' => $this->geofenceIds,
            'attributes'  => $this->attributes,
        ];
    }

    private static function parseTime(mixed $raw, string $field): ?CarbonImmutable
    {
        if (is_string($raw) && $raw !== '') {
            try {
                return CarbonImmutable::parse($raw);
            } catch (Throwable $e) {
                Log::info("Failed to parse Position {$field}: ".$e->getMessage());
            }
        }

        return null;
    }
}
