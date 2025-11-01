<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests;

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

    /**
     * Resolves and returns the API endpoint for creating a device.
    */
    public function resolveEndpoint(): string
    {
        return '/devices';
    }

    /**
     * Create DTO from the response.
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): DeviceData
    {
        return DeviceData::fromArray($response->json());
    }

    /**
     * Returns the default body for the request.
     *
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }
}
