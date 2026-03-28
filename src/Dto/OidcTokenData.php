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
        if (! isset($data['access_token']) || $data['access_token'] === '') {
            throw new \InvalidArgumentException(message: 'The access_token is required.');
        }

        if (! isset($data['expires_in'])) {
            throw new \InvalidArgumentException(message: 'The expires_in is required.');
        }

        return new self(
            accessToken: (string) $data['access_token'],
            tokenType: (string) ($data['token_type'] ?? 'Bearer'),
            expiresIn: (int) $data['expires_in'],
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
