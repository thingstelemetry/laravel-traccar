<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Enums\DeviceStatus;
use ThingsTelemetry\Traccar\Support\DataHelper;
use ThingsTelemetry\Traccar\Enums\DeviceCategory;
use ThingsTelemetry\Traccar\Support\ParsesTimestamps;

class DeviceData
{
    use ParsesTimestamps;
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
        return new self(
            id: DataHelper::nullableInt(data: $data, key: 'id'),
            name: (string) ($data['name'] ?? ''),
            uniqueId: (string) ($data['uniqueId'] ?? ''),
            status: DeviceStatus::tryFrom((string) ($data['status'] ?? '')) ?? DeviceStatus::default(),
            disabled: (bool) ($data['disabled'] ?? false),
            lastUpdate: self::parseTimestamp(raw: $data['lastUpdate'] ?? null, field: 'lastUpdate'),
            positionId: DataHelper::nullableInt(data: $data, key: 'positionId'),
            groupId: DataHelper::nullableInt(data: $data, key: 'groupId'),
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
