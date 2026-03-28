<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

use Throwable;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Log;

class AuditData
{
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
        $rawActionTime = $data['actionTime'] ?? null;
        $actionTime = null;

        if (is_string($rawActionTime) && $rawActionTime !== '') {
            try {
                $actionTime = CarbonImmutable::parse($rawActionTime);
            } catch (Throwable $e) {
                Log::warning('Failed to parse Audit actionTime: '.$e->getMessage());
            }
        }

        return new self(
            id: (int) ($data['id'] ?? 0),
            userId: (int) ($data['userId'] ?? 0),
            userEmail: $data['userEmail'] ?? null,
            type: (string) ($data['type'] ?? ''),
            actionTime: $actionTime,
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
