<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

class NotificationTypeData
{
    public function __construct(public string $type)
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(type: (string) ($data['type'] ?? ''));
    }
}
