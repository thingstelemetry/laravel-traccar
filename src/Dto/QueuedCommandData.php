<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

class QueuedCommandData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public int $id,
        public int $deviceId,
        public string $type,
        public bool $textChannel = false,
        public array $attributes = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            deviceId: (int) ($data['deviceId'] ?? 0),
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
            'type'        => $this->type,
            'textChannel' => $this->textChannel,
            'attributes'  => $this->attributes,
        ];
    }
}
