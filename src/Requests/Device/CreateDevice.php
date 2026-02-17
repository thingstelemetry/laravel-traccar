<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Device;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use ThingsTelemetry\Traccar\Dto\DeviceData;

class CreateDevice extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(public DeviceData $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/devices';
    }

    /**  @throws JsonException */
    public function createDtoFromResponse(Response $response): DeviceData
    {
        return DeviceData::fromArray($response->json());
    }

    /**  @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }
}
