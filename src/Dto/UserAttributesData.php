<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Dto;

/**
 * Generic user attributes bag.
 *
 * Traccar user attributes are not fully documented and can vary per instance.
 * This DTO preserves the attributes payload while following the existing pattern.
 */
class UserAttributesData
{
    /** @param array<string, mixed> $attributes */
    public function __construct(public array $attributes = [])
    {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(attributes: $data);
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return $this->attributes;
    }
}
