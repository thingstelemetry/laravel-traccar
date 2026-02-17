<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Server;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Dto\ServerData;

class GetServerInformation extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/server';
    }

    /** @throws JsonException */
    public function createDtoFromResponse(Response $response): ServerData
    {
        return ServerData::fromArray($response->json());
    }
}
