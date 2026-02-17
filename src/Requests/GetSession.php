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
        $endpoint = '/session';

        if ($this->token !== null) {
            $endpoint .= '?token=' . urlencode($this->token);
        }

        return $endpoint;
    }

    /** @throws JsonException */
    public function createDtoFromResponse(Response $response): UserData
    {
        return UserData::fromArray($response->json());
    }
}
