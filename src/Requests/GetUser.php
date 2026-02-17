<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Dto\UserData;
use Saloon\Exceptions\Request\Statuses\NotFoundException;

class GetUser extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public int $id)
    {
    }

    public function resolveEndpoint(): string
    {
        return "/users/{$this->id}";
    }

    /**
     * @throws JsonException
     * @throws \Saloon\Exceptions\Request\Statuses\NotFoundException
     */
    public function createDtoFromResponse(Response $response): UserData
    {
        $json = $response->json();

        if (! is_array($json) || $json === []) {
            throw new NotFoundException(
                response: $response,
                message: 'Traccar user was not found. Check the user ID and try again.'
            );
        }

        return UserData::fromArray($json);
    }
}
