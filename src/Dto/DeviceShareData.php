<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

use Carbon\CarbonInterface;

class DeviceShareData
{
    public function __construct(
        public int $deviceId,
        public string $token,
        public CarbonInterface $expiration,
        public string $url,
    ) {
    }

    public static function fromToken(int $deviceId, string $token, CarbonInterface $expiration, string $apiBaseUrl): self
    {
        $uiBase = mb_rtrim(string: $apiBaseUrl, characters: '/');

        if (str_ends_with(haystack: $uiBase, needle: '/api')) {
            $uiBase = mb_substr($uiBase, 0, -4);
        }

        $url = $uiBase.'/?token='.urlencode(string: $token);

        return new self(
            deviceId: $deviceId,
            token: $token,
            expiration: $expiration,
            url: $url,
        );
    }

    public function toArray(): array
    {
        return [
            'deviceId'   => $this->deviceId,
            'token'      => $this->token,
            'expiration' => $this->expiration->toIso8601String(),
            'url'        => $this->url,
        ];
    }
}
