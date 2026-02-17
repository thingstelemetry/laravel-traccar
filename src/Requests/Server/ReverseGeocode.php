<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Server;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class ReverseGeocode extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected float $latitude,
        protected float $longitude,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/server/geocode';
    }

    public function createDtoFromResponse(Response $response): string
    {
        return mb_trim($response->body());
    }

    /** @return array<string, mixed> */
    protected function defaultQuery(): array
    {
        return [
            'latitude'  => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }

    /** @return array<string, string> */
    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'text/plain, */*',
        ];
    }
}
