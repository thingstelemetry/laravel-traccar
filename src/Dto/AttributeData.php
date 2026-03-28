<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

class AttributeData
{
    public function __construct(
        public string $description,
        public string $attribute,
        public string $expression,
        public string $type,
        public ?int $id = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: array_key_exists(key: 'id', array: $data) ? (is_null($data['id']) ? null : (int) $data['id']) : null,
            description: (string) ($data['description'] ?? ''),
            attribute: (string) ($data['attribute'] ?? ''),
            expression: (string) ($data['expression'] ?? ''),
            type: (string) ($data['type'] ?? ''),
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'id'          => $this->id,
            'description' => $this->description,
            'attribute'   => $this->attribute,
            'expression'  => $this->expression,
            'type'        => $this->type,
        ];
    }
}
