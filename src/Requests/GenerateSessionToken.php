<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Carbon\CarbonInterface;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasFormBody;
use ThingsTelemetry\Traccar\Dto\SessionTokenData;

class GenerateSessionToken extends Request implements HasBody
{
    use HasFormBody;

    protected Method $method = Method::POST;

    public function __construct(public ?CarbonInterface $expiration = null)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/session/token';
    }

    public function createDtoFromResponse(Response $response): SessionTokenData
    {
        return SessionTokenData::fromString($response->body());
    }

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        $body = [];

        if ($this->expiration !== null) {
            $body['expiration'] = $this->expiration->toIso8601String();
        }

        return $body;
    }
}
