<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

class JwksKeyData
{
    public function __construct(
        public string $kty,
        public string $alg,
        public string $use,
        public string $kid,
        public string $n,
        public string $e,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            kty: (string) ($data['kty'] ?? ''),
            alg: (string) ($data['alg'] ?? ''),
            use: (string) ($data['use'] ?? ''),
            kid: (string) ($data['kid'] ?? ''),
            n: (string) ($data['n'] ?? ''),
            e: (string) ($data['e'] ?? ''),
        );
    }

    public function toArray(): array
    {
        return [
            'kty' => $this->kty,
            'alg' => $this->alg,
            'use' => $this->use,
            'kid' => $this->kid,
            'n'   => $this->n,
            'e'   => $this->e,
        ];
    }
}
