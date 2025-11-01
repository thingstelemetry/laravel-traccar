<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Dto\UserData;

class GetAllUsers extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/users';
    }

    /**
     * @return array<int, UserData>
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(
            callback: fn ($u) => UserData::fromArray(data: (array) $u),
            array: $response->json()
        );
    }
}
