<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Group;

use Throwable;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Dto\GroupData;
use Saloon\Exceptions\Request\Statuses\NotFoundException;

class GetGroup extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public int $id)
    {
    }

    public function resolveEndpoint(): string
    {
        return "/groups/{$this->id}";
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
            message: 'Traccar group was not found. Check the group ID and try again.'
        );
    }

    public function createDtoFromResponse(Response $response): GroupData
    {
        return GroupData::fromArray(data: $response->json());
    }
}
