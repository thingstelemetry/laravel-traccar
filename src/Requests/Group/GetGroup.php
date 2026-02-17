<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Group;

use JsonException;
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

    /**
     * @throws JsonException
     * @throws \Saloon\Exceptions\Request\Statuses\NotFoundException
     */
    public function createDtoFromResponse(Response $response): GroupData
    {
        $json = $response->json();

        if (! is_array($json) || $json === []) {
            throw new NotFoundException(
                response: $response,
                message: 'Traccar group was not found. Check the group ID and try again.'
            );
        }

        return GroupData::fromArray($json);
    }
}
