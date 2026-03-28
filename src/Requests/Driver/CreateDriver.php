<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Driver;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use ThingsTelemetry\Traccar\Dto\DriverData;

class CreateDriver extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(public DriverData $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/drivers';
    }

    public function createDtoFromResponse(Response $response): DriverData
    {
        return DriverData::fromArray(data: $response->json());
    }

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }
}
