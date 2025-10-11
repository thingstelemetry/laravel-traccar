<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Requests;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TrackTelemetry\Traccar\Dto\DeviceData;

class GetAllDevices extends Request
{
    protected Method $method = Method::GET;

    /**
     * Resolves and returns the API endpoint for initializing a transaction.
     */
    public function resolveEndpoint(): string
    {
        return '/devices';
    }

    /**
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): mixed
    {
        return collect($response->json())
            ->map(fn($device) => DeviceData::fromArray($device));
    }
}
