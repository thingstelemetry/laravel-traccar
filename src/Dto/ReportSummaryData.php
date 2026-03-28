<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

class ReportSummaryData
{
    public function __construct(
        public int $deviceId,
        public string $deviceName,
        public float $maxSpeed,
        public float $averageSpeed,
        public float $distance,
        public float $spentFuel,
        public int $engineHours,
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
            engineHours: (int) ($data['engineHours'] ?? 0),
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'deviceId'     => $this->deviceId,
            'deviceName'   => $this->deviceName,
            'maxSpeed'     => $this->maxSpeed,
            'averageSpeed' => $this->averageSpeed,
            'distance'     => $this->distance,
            'spentFuel'    => $this->spentFuel,
            'engineHours'  => $this->engineHours,
        ];
    }
}
