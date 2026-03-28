<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Support\ParsesTimestamps;

class AuditData
{
    use ParsesTimestamps;
    public function __construct(
        public int $id,
        public int $userId,
        public ?string $userEmail,
        public string $type,
        public ?CarbonImmutable $actionTime,
        /** @var array<string, mixed> */
        public array $attributes = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            userId: (int) ($data['userId'] ?? 0),
            userEmail: $data['userEmail'] ?? null,
            type: (string) ($data['type'] ?? ''),
            actionTime: self::parseTimestamp(raw: $data['actionTime'] ?? null, field: 'actionTime'),
            attributes: is_array($data['attributes'] ?? null) ? $data['attributes'] : [],
        );
    }

    public function toArray(): array
    {
        return [
            'id'         => $this->id,
            'userId'     => $this->userId,
            'userEmail'  => $this->userEmail,
            'type'       => $this->type,
            'actionTime' => $this->actionTime?->toIso8601String(),
            'attributes' => $this->attributes,
        ];
    }
}
