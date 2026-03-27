<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\User;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GenerateTotpSecret extends Request
{
    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/users/totp';
    }

    public function createDtoFromResponse(Response $response): string
    {
        return $response->body();
    }
}
