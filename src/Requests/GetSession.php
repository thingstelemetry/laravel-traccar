<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Dto\UserData;

class GetSession extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public ?string $token = null)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/session';
    }

    /** @throws JsonException */
    public function createDtoFromResponse(Response $response): UserData
    {
        return UserData::fromArray($response->json());
    }

    protected function defaultQuery(): array
    {
        if ($this->token === null) {
            return [];
        }

        return ['token' => $this->token];
    }
}
