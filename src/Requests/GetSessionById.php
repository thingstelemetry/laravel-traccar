<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Dto\UserData;

class GetSessionById extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public int $userId)
    {
    }

    public function resolveEndpoint(): string
    {
        return "/session/{$this->userId}";
    }

    /** @throws JsonException */
    public function createDtoFromResponse(Response $response): UserData
    {
        return UserData::fromArray($response->json());
    }
}
