<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

use Illuminate\Support\Collection;

class JwksResponseData
{
    /**
     * @param  Collection<int, JwksKeyData>  $keys
     */
    public function __construct(
        public Collection $keys,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            keys: collect(value: $data['keys'] ?? [])
                ->map(callback: fn (array $key) => JwksKeyData::fromArray(data: $key)),
        );
    }

    public function toArray(): array
    {
        return [
            'keys' => $this->keys->map(callback: fn (JwksKeyData $key) => $key->toArray())->toArray(),
        ];
    }
}
