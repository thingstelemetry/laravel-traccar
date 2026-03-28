<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

class OidcTokenData
{
    public function __construct(
        public string $accessToken,
        public string $tokenType,
        public int $expiresIn,
        public ?string $idToken = null,
        public ?string $scope = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            accessToken: (string) ($data['access_token'] ?? ''),
            tokenType: (string) ($data['token_type'] ?? 'Bearer'),
            expiresIn: (int) ($data['expires_in'] ?? 0),
            idToken: (string) ($data['id_token'] ?? '') ?: null,
            scope: (string) ($data['scope'] ?? '') ?: null,
        );
    }

    public function toArray(): array
    {
        return [
            'access_token' => $this->accessToken,
            'token_type'   => $this->tokenType,
            'expires_in'   => $this->expiresIn,
            'id_token'     => $this->idToken,
            'scope'        => $this->scope,
        ];
    }
}
