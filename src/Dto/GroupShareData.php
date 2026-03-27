<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

use Carbon\CarbonInterface;

class GroupShareData
{
    public function __construct(
        public int $groupId,
        public string $token,
        public CarbonInterface $expiration,
        public string $url,
    ) {
    }

    public static function fromToken(int $groupId, string $token, CarbonInterface $expiration, string $apiBaseUrl): self
    {
        $uiBase = mb_rtrim(string: $apiBaseUrl, characters: '/');

        if (str_ends_with(haystack: $uiBase, needle: '/api')) {
            $uiBase = mb_substr($uiBase, 0, -4);
        }

        $url = $uiBase.'/?token='.urlencode(string: $token);

        return new self(
            groupId: $groupId,
            token: $token,
            expiration: $expiration,
            url: $url,
        );
    }

    public function toArray(): array
    {
        return [
            'groupId'    => $this->groupId,
            'token'      => $this->token,
            'expiration' => $this->expiration->toIso8601String(),
            'url'        => $this->url,
        ];
    }
}
