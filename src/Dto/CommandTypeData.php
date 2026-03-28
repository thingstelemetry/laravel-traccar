<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

class CommandTypeData
{
    public function __construct(public string $type)
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(type: (string) ($data['type'] ?? ''));
    }

    /** @return array<string, string> */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
        ];
    }
}
