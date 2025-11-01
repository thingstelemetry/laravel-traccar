<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Dto;

use Throwable;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Log;

class ServerStatisticsData
{
    public function __construct(
        public CarbonImmutable $captureTime,
        public int $activeUsers,
        public int $activeDevices,
        public int $requests,
        public int $messagesReceived,
        public int $messagesStored,
    ) {
    }

    public static function fromArray(array $data): self
    {
        $time = CarbonImmutable::now();
        try {
            $raw = (string) ($data['captureTime'] ?? '');
            if ($raw !== '') {
                $time = CarbonImmutable::parse($raw);
            }
        } catch (Throwable $e) {
            Log::info('Failed to parse statistics captureTime: '.$e->getMessage());
        }

        return new self(
            captureTime: $time,
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
            'captureTime'      => $this->captureTime->toIso8601String(),
            'activeUsers'      => $this->activeUsers,
            'activeDevices'    => $this->activeDevices,
            'requests'         => $this->requests,
            'messagesReceived' => $this->messagesReceived,
            'messagesStored'   => $this->messagesStored,
        ];
    }
}
