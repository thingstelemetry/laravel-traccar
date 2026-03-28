<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Oidc;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Dto\JwksResponseDto;

class GetJwks extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/oidc/jwks';
    }

    public function createDtoFromResponse(Response $response): JwksResponseDto
    {
        return JwksResponseDto::fromArray(data: $response->json());
    }
}
