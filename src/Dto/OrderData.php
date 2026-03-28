<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

class OrderData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $uniqueId,
        public string $description,
        public string $fromAddress,
        public string $toAddress,
        public array $attributes = [],
        public ?int $id = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: array_key_exists(key: 'id', array: $data) ? (is_null($data['id']) ? null : (int) $data['id']) : null,
            uniqueId: (string) ($data['uniqueId'] ?? ''),
            description: (string) ($data['description'] ?? ''),
            fromAddress: (string) ($data['fromAddress'] ?? ''),
            toAddress: (string) ($data['toAddress'] ?? ''),
            attributes: is_array($data['attributes'] ?? null) ? $data['attributes'] : [],
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'id'          => $this->id,
            'uniqueId'    => $this->uniqueId,
            'description' => $this->description,
            'fromAddress' => $this->fromAddress,
            'toAddress'   => $this->toAddress,
            'attributes'  => $this->attributes,
        ];
    }
}
