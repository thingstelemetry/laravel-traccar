<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

class GeofenceData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $name,
        public string $description,
        public string $area,
        public array $attributes = [],
        public ?int $id = null,
        public ?int $calendarId = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: array_key_exists(key: 'id', array: $data) ? (is_null($data['id']) ? null : (int) $data['id']) : null,
            name: (string) ($data['name'] ?? ''),
            description: (string) ($data['description'] ?? ''),
            area: (string) ($data['area'] ?? ''),
            calendarId: array_key_exists(key: 'calendarId', array: $data) ? (is_null($data['calendarId']) ? null : (int) $data['calendarId']) : null,
            attributes: is_array($data['attributes'] ?? null) ? $data['attributes'] : [],
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'area'        => $this->area,
            'calendarId'  => $this->calendarId,
            'attributes'  => $this->attributes,
        ];
    }
}
