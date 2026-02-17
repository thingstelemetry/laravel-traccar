<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Server;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Illuminate\Support\Collection;

class GetServerTimezones extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/server/timezones';
    }

    /**
     * @return Collection<int, string>
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect($response->json());
    }
}
