<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

class CommandData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $type,
        public array $attributes = [],
        public ?int $id = null,
        public ?int $deviceId = null,
        public string $description = '',
        public bool $textChannel = false,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: array_key_exists(key: 'id', array: $data) ? (is_null($data['id']) ? null : (int) $data['id']) : null,
            deviceId: array_key_exists(key: 'deviceId', array: $data) ? (is_null($data['deviceId']) ? null : (int) $data['deviceId']) : null,
            description: (string) ($data['description'] ?? ''),
            type: (string) ($data['type'] ?? ''),
            textChannel: (bool) ($data['textChannel'] ?? false),
            attributes: is_array($data['attributes'] ?? null) ? $data['attributes'] : [],
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'id'          => $this->id,
            'deviceId'    => $this->deviceId,
            'description' => $this->description,
            'type'        => $this->type,
            'textChannel' => $this->textChannel,
            'attributes'  => $this->attributes,
        ];
    }
}
