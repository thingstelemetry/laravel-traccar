<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Requests;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Illuminate\Support\Collection;
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
     *
     * @return Collection<DeviceData|mixed>
     */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect(value: $response->json())
            ->map(callback: fn ($device) => DeviceData::fromArray(data: $device));
    }
}
