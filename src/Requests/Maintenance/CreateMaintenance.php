<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Maintenance;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use ThingsTelemetry\Traccar\Dto\MaintenanceData;

class CreateMaintenance extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(public MaintenanceData $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/maintenance';
    }

    public function createDtoFromResponse(Response $response): MaintenanceData
    {
        return MaintenanceData::fromArray(data: $response->json());
    }

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }
}
