<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Dto;

use Carbon\CarbonImmutable;

class DeviceData
{
    public function __construct(
        public int $id,
        public string $name,
        public string $uniqueId,
        public string $status,
        public bool $disabled,
        public ?CarbonImmutable $lastUpdate,
        public ?int $positionId,
        public ?int $groupId,
        public ?string $phone,
        public ?string $model,
        public ?string $contact,
        public ?string $category,
        /** @var array<string,mixed> */
        public DeviceAttributesData $attributes,
    ) {
    }

    public static function fromArray(array $data): self
    {
        $rawLastUpdate = $data['lastUpdate'] ?? null;
        $lastUpdate = null;

        if (is_string($rawLastUpdate) && $rawLastUpdate !== '') {
            try {
                $lastUpdate = CarbonImmutable::parse($rawLastUpdate);
            } catch (\Throwable $e) {
                error_log('Failed to parse lastUpdate: ' . $e->getMessage());
            }
        }

        return new self(
            id: (int) $data['id'],
            name: (string) ($data['name'] ?? ''),
            uniqueId: (string) ($data['uniqueId'] ?? ''),
            status: (string) ($data['status'] ?? ''),
            disabled: (bool) ($data['disabled'] ?? false),
            lastUpdate: $lastUpdate,
            positionId: array_key_exists('positionId', $data) ? (is_null($data['positionId']) ? null : (int) $data['positionId']) : null,
            groupId: array_key_exists('groupId', $data) ? (is_null($data['groupId']) ? null : (int) $data['groupId']) : null,
            phone: $data['phone'] ?? null,
            model: $data['model'] ?? null,
            contact: $data['contact'] ?? null,
            category: $data['category'] ?? null,
            attributes: DeviceAttributesData::fromArray(data: $data['attributes'] ?? []),
        );
    }

    public function toArray(): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'uniqueId'    => $this->uniqueId,
            'status'      => $this->status,
            'disabled'    => $this->disabled,
            'lastUpdate'  => $this->lastUpdate?->toIso8601String(),
            'positionId'  => $this->positionId,
            'groupId'     => $this->groupId,
            'phone'       => $this->phone,
            'model'       => $this->model,
            'contact'     => $this->contact,
            'category'    => $this->category,
            'attributes'       => $this->attributes->toArray(),
        ];
    }
}
