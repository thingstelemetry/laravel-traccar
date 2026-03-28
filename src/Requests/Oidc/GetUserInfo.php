<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Oidc;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Dto\OidcUserInfoData;

class GetUserInfo extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/oidc/userinfo';
    }

    public function createDtoFromResponse(Response $response): OidcUserInfoData
    {
        return OidcUserInfoData::fromArray($response->json());
    }
}
