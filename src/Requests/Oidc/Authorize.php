<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Oidc;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class Authorize extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public string $clientId,
        public string $redirectUri,
        public ?string $state = null,
        public ?string $scope = null,
        public ?string $responseType = null,
        public ?string $codeChallenge = null,
        public ?string $codeChallengeMethod = null,
        public ?string $nonce = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/oidc/authorize';
    }

    protected function defaultQuery(): array
    {
        return array_filter(array: [
            'client_id'             => $this->clientId,
            'redirect_uri'          => $this->redirectUri,
            'state'                 => $this->state,
            'scope'                 => $this->scope,
            'response_type'         => $this->responseType,
            'code_challenge'        => $this->codeChallenge,
            'code_challenge_method' => $this->codeChallengeMethod,
            'nonce'                 => $this->nonce,
        ], callback: fn (mixed $v): bool => $v !== null);
    }
}
