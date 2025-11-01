<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use ThingsTelemetry\Traccar\Dto\ServerData;

class UpdateServerInformation extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function __construct(public ServerData $data)
    {
    }

    /**
     * Resolves and returns the API endpoint for initializing a transaction.
     */
    public function resolveEndpoint(): string
    {
        return '/server';
    }

    /**
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): ServerData
    {
        return ServerData::fromArray($response->json());
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
