<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TrackTelemetry\Traccar\Enums\Status;
use TrackTelemetry\Traccar\Dto\StatusData;

class DeleteDevice extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(public int $id)
    {
    }

    /**
     * Resolves and returns the API endpoint for deleting a device.
     */
    public function resolveEndpoint(): string
    {
        return "/devices/{$this->id}";
    }

    /**
     * Return an enum status from the response.
     */
    public function createDtoFromResponse(Response $response): StatusData
    {
        return new StatusData(status: Status::SUCCESS);
    }
}
