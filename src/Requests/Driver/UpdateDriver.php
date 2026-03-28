<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Driver;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use InvalidArgumentException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use ThingsTelemetry\Traccar\Dto\DriverData;

class UpdateDriver extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function __construct(public DriverData $data)
    {
        if (is_null($data->id)) {
            throw new InvalidArgumentException(message: 'Driver ID is required for update operations.');
        }
    }

    public function resolveEndpoint(): string
    {
        return "/drivers/{$this->data->id}";
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
