<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\User;

use Throwable;
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

    public function hasRequestFailed(Response $response): ?bool
    {
        if ($response->status() !== 200) {
            return null;
        }

        $json = $response->json();

        return ! is_array($json) || $json === [];
    }

    public function getRequestException(Response $response, ?Throwable $senderException): ?Throwable
    {
        if ($response->status() !== 200) {
            return null;
        }

        return new NotFoundException(
            response: $response,
            message: 'Traccar user was not found. Check the user ID and try again.'
        );
    }

    public function createDtoFromResponse(Response $response): UserData
    {
        return UserData::fromArray(data: $response->json());
    }
}
