<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

class OidcUserInfoData
{
    public function __construct(
        public string $sub,
        public string $name,
        public string $email,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            sub: (string) ($data['sub'] ?? ''),
            name: (string) ($data['name'] ?? ''),
            email: (string) ($data['email'] ?? ''),
        );
    }

    public function toArray(): array
    {
        return [
            'sub'   => $this->sub,
            'name'  => $this->name,
            'email' => $this->email,
        ];
    }
}
