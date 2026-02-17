<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use InvalidArgumentException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use ThingsTelemetry\Traccar\Dto\DeviceData;

class UpdateDevice extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function __construct(public DeviceData $data)
    {
        if (is_null($data->id)) {
            throw new InvalidArgumentException(message: 'Device ID is required for update operations.');
        }
    }

    public function resolveEndpoint(): string
    {
        return "/devices/{$this->data->id}";
    }

    /** @throws JsonException */
    public function createDtoFromResponse(Response $response): DeviceData
    {
        return DeviceData::fromArray(data: $response->json());
    }

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }
}
