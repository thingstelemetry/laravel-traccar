<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

class GroupData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $name,
        public array $attributes = [],
        public ?int $id = null,
        public ?int $groupId = null,
    ) {
    }

    /** @return self */
    public static function fromArray(array $data): self
    {
        return new self(
            id: array_key_exists(key: 'id', array: $data) ? (is_null($data['id']) ? null : (int) $data['id']) : null,
            name: (string) ($data['name'] ?? ''),
            groupId: array_key_exists(key: 'groupId', array: $data) ? (is_null($data['groupId']) ? null : (int) $data['groupId']) : null,
            attributes: (array) ($data['attributes'] ?? []),
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'groupId'    => $this->groupId,
            'attributes' => $this->attributes,
        ];
    }
}
