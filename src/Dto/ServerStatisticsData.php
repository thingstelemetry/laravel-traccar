<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Support\ParsesTimestamps;

class ServerStatisticsData
{
    use ParsesTimestamps;
    public function __construct(
        public ?CarbonImmutable $captureTime,
        public int $activeUsers,
        public int $activeDevices,
        public int $requests,
        public int $messagesReceived,
        public int $messagesStored,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            captureTime: self::parseTimestamp(raw: $data['captureTime'] ?? null, field: 'captureTime'),
            activeUsers: (int) ($data['activeUsers'] ?? 0),
            activeDevices: (int) ($data['activeDevices'] ?? 0),
            requests: (int) ($data['requests'] ?? 0),
            messagesReceived: (int) ($data['messagesReceived'] ?? 0),
            messagesStored: (int) ($data['messagesStored'] ?? 0),
        );
    }

    public function toArray(): array
    {
        return [
            'captureTime'      => $this->captureTime?->toIso8601String(),
            'activeUsers'      => $this->activeUsers,
            'activeDevices'    => $this->activeDevices,
            'requests'         => $this->requests,
            'messagesReceived' => $this->messagesReceived,
            'messagesStored'   => $this->messagesStored,
        ];
    }
}
