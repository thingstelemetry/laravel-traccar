<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Device;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Dto\DeviceData;
use Saloon\Exceptions\Request\Statuses\NotFoundException;

class GetDevice extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public int $id)
    {
    }

    public function resolveEndpoint(): string
    {
        return "/devices/{$this->id}";
    }

    /**
     * @throws JsonException
     * @throws \Saloon\Exceptions\Request\Statuses\NotFoundException
     */
    public function createDtoFromResponse(Response $response): DeviceData
    {
        $json = $response->json();

        if (! is_array($json) || $json === []) {
            throw new NotFoundException(
                response: $response,
                message: 'Traccar device was not found. Check the device ID and try again.'
            );
        }

        return DeviceData::fromArray($json);
    }
}
