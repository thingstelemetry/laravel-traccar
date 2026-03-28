<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\User;

use Saloon\Http\Response;
use InvalidArgumentException;
use ThingsTelemetry\Traccar\Dto\UserData;
use ThingsTelemetry\Traccar\Requests\Abstract\UpdateRequest;

class UpdateUser extends UpdateRequest
{
    public function __construct(public UserData $data)
    {
        if (is_null($data->id)) {
            throw new InvalidArgumentException(message: 'User ID is required for update operations.');
        }
    }

    public function resolveEndpoint(): string
    {
        return "/users/{$this->data->id}";
    }

    public function createDtoFromResponse(Response $response): UserData
    {
        return UserData::fromArray(data: $response->json());
    }
}
