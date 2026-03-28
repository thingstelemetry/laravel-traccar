<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

use Throwable;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Log;

class EventData
{
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
        $rawEventTime = $data['eventTime'] ?? null;
        $eventTime = null;

        if (is_string($rawEventTime) && $rawEventTime !== '') {
            try {
                $eventTime = CarbonImmutable::parse($rawEventTime);
            } catch (Throwable $e) {
                Log::info('Failed to parse Event eventTime: '.$e->getMessage());
            }
        }

        return new self(
            id: (int) ($data['id'] ?? 0),
            type: (string) ($data['type'] ?? ''),
            eventTime: $eventTime,
            deviceId: (int) ($data['deviceId'] ?? 0),
            positionId: array_key_exists('positionId', $data) ? (is_null($data['positionId']) ? null : (int) $data['positionId']) : null,
            geofenceId: array_key_exists('geofenceId', $data) ? (is_null($data['geofenceId']) ? null : (int) $data['geofenceId']) : null,
            maintenanceId: array_key_exists('maintenanceId', $data) ? (is_null($data['maintenanceId']) ? null : (int) $data['maintenanceId']) : null,
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
