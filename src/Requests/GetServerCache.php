<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetServerCache extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/server/cache';
    }

    public function createDtoFromResponse(Response $response): string
    {
        return mb_trim((string) $response->body());
    }

    /**
     * Override headers to accept plain text responses.
     *
     * @return array<string, string>
     */
    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'text/plain, */*',
        ];
    }
}
