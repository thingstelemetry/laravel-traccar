<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

use Throwable;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Log;
use ThingsTelemetry\Traccar\Enums\DeviceStatus;
use ThingsTelemetry\Traccar\Enums\DeviceCategory;

class DeviceData
{
    public function __construct(
        public string $name,
        public string $uniqueId,
        public DeviceAttributesData $attributes,
        public ?int $id = null,
        public DeviceStatus $status = DeviceStatus::UNKNOWN,
        public bool $disabled = false,
        public ?CarbonImmutable $lastUpdate = null,
        public ?int $positionId = null,
        public ?int $groupId = null,
        public ?string $phone = null,
        public ?string $model = null,
        public ?string $contact = null,
        public DeviceCategory $category = DeviceCategory::DEFAULT,
    ) {
    }

    public static function fromArray(array $data): self
    {
        $rawLastUpdate = $data['lastUpdate'] ?? null;
        $lastUpdate = null;

        if (is_string($rawLastUpdate) && $rawLastUpdate !== '') {
            try {
                $lastUpdate = CarbonImmutable::parse($rawLastUpdate);
            } catch (Throwable $e) {
                Log::info("Failed to parse {$data['uniqueId']} Device lastUpdate: ".$e->getMessage());
            }
        }

        return new self(
            id: array_key_exists(key: 'id', array: $data) ? (is_null($data['id']) ? null : (int) $data['id']) : null,
            name: (string) ($data['name'] ?? ''),
            uniqueId: (string) ($data['uniqueId'] ?? ''),
            status: DeviceStatus::tryFrom((string) ($data['status'] ?? '')) ?? DeviceStatus::default(),
            disabled: (bool) ($data['disabled'] ?? false),
            lastUpdate: $lastUpdate,
            positionId: array_key_exists(key: 'positionId', array: $data) ? (is_null($data['positionId']) ? null : (int) $data['positionId']) : null,
            groupId: array_key_exists(key: 'groupId', array: $data) ? (is_null($data['groupId']) ? null : (int) $data['groupId']) : null,
            phone: $data['phone'] ?? null,
            model: $data['model'] ?? null,
            contact: $data['contact'] ?? null,
            category: DeviceCategory::tryFrom((string) ($data['category'] ?? '')) ?? DeviceCategory::default(),
            attributes: DeviceAttributesData::fromArray(data: $data['attributes'] ?? []),
        );
    }

    public function toArray(): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'uniqueId'   => $this->uniqueId,
            'status'     => $this->status->value,
            'disabled'   => $this->disabled,
            'lastUpdate' => $this->lastUpdate?->toIso8601String(),
            'positionId' => $this->positionId,
            'groupId'    => $this->groupId,
            'phone'      => $this->phone,
            'model'      => $this->model,
            'contact'    => $this->contact,
            'category'   => $this->category->value,
            'attributes' => $this->attributes->toArray(),
        ];
    }
}
