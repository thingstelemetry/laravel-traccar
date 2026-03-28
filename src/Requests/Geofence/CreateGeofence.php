<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Geofence;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use ThingsTelemetry\Traccar\Dto\GeofenceData;

class CreateGeofence extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(public GeofenceData $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/geofences';
    }

    public function createDtoFromResponse(Response $response): GeofenceData
    {
        return GeofenceData::fromArray(data: $response->json());
    }

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }
}
