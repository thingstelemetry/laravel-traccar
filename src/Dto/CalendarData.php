<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

class CalendarData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $name,
        public string $data,
        public array $attributes = [],
        public ?int $id = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: array_key_exists(key: 'id', array: $data) ? (is_null($data['id']) ? null : (int) $data['id']) : null,
            name: (string) ($data['name'] ?? ''),
            data: (string) ($data['data'] ?? ''),
            attributes: is_array($data['attributes'] ?? null) ? $data['attributes'] : [],
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'data'       => $this->data,
            'attributes' => $this->attributes,
        ];
    }
}
