<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Event;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Dto\EventData;

class GetEvent extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public int $id)
    {
    }

    public function resolveEndpoint(): string
    {
        return "/events/{$this->id}";
    }

    /** @throws JsonException */
    public function createDtoFromResponse(Response $response): EventData
    {
        return EventData::fromArray($response->json());
    }
}
