<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

class NotificationData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $type,
        public string $notificators,
        public array $attributes = [],
        public ?int $id = null,
        public ?string $description = null,
        public bool $always = false,
        public ?int $commandId = null,
        public ?int $calendarId = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: array_key_exists(key: 'id', array: $data) ? (is_null($data['id']) ? null : (int) $data['id']) : null,
            type: (string) ($data['type'] ?? ''),
            description: $data['description'] ?? null,
            always: (bool) ($data['always'] ?? false),
            commandId: array_key_exists(key: 'commandId', array: $data) ? (is_null($data['commandId']) ? null : (int) $data['commandId']) : null,
            notificators: (string) ($data['notificators'] ?? ''),
            calendarId: array_key_exists(key: 'calendarId', array: $data) ? (is_null($data['calendarId']) ? null : (int) $data['calendarId']) : null,
            attributes: is_array($data['attributes'] ?? null) ? $data['attributes'] : [],
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'id'           => $this->id,
            'type'         => $this->type,
            'description'  => $this->description,
            'always'       => $this->always,
            'commandId'    => $this->commandId,
            'notificators' => $this->notificators,
            'calendarId'   => $this->calendarId,
            'attributes'   => $this->attributes,
        ];
    }
}
