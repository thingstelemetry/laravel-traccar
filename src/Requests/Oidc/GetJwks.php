<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Oidc;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetJwks extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/oidc/jwks';
    }
}
