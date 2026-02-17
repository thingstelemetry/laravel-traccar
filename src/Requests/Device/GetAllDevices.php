<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Device;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\DeviceData;

class GetAllDevices extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/devices';
    }

    /**
     * @return Collection<int, DeviceData>
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect($response->json())
            ->map(fn ($device) => DeviceData::fromArray($device));
    }
}
