<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetOpenIdCallback extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public string $queryString)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/session/openid/callback?' . $this->queryString;
    }

    public function createDtoFromResponse(Response $response): string
    {
        return $response->header('Location') ?? '';
    }
}
