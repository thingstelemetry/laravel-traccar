<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Oidc;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Dto\JwksResponseData;

class GetJwks extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/oidc/jwks';
    }

    public function createDtoFromResponse(Response $response): JwksResponseData
    {
        return JwksResponseData::fromArray(data: $response->json());
    }
}
