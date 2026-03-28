<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Oidc;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasFormBody;
use ThingsTelemetry\Traccar\Dto\OidcTokenData;

class GetToken extends Request implements HasBody
{
    use HasFormBody;

    protected Method $method = Method::POST;

    public function __construct(
        public string $grantType,
        public string $code,
        public ?string $redirectUri = null,
        public ?string $clientId = null,
        public ?string $clientSecret = null,
        public ?string $codeVerifier = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/oidc/token';
    }

    public function createDtoFromResponse(Response $response): OidcTokenData
    {
        return OidcTokenData::fromArray($response->json());
    }

    protected function defaultBody(): array
    {
        return array_filter([
            'grant_type'    => $this->grantType,
            'code'          => $this->code,
            'redirect_uri'  => $this->redirectUri,
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code_verifier' => $this->codeVerifier,
        ]);
    }
}
