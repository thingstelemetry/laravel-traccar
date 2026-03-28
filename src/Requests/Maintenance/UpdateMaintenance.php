<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Maintenance;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use InvalidArgumentException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use ThingsTelemetry\Traccar\Dto\MaintenanceData;

class UpdateMaintenance extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function __construct(public MaintenanceData $data)
    {
        if (is_null($data->id)) {
            throw new InvalidArgumentException(message: 'Maintenance ID is required for update operations.');
        }
    }

    public function resolveEndpoint(): string
    {
        return "/maintenance/{$this->data->id}";
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
