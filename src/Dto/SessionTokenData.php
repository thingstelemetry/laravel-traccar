<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

class SessionTokenData
{
    public function __construct(
        public string $token
    ) {
    }

    public static function fromString(string $token): self
    {
        return new self(token: $token);
    }

    /** @return array<string, string> */
    public function toArray(): array
    {
        return [
            'token' => $this->token,
        ];
    }
}
