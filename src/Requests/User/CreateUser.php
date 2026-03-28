<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\User;

use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Dto\UserData;
use ThingsTelemetry\Traccar\Requests\Abstract\CreateRequest;

class CreateUser extends CreateRequest
{
    public function __construct(public UserData $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/users';
    }

    public function createDtoFromResponse(Response $response): UserData
    {
        return UserData::fromArray(data: $response->json());
    }
}
