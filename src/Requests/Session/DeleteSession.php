<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Session;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;

class DeleteSession extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return '/session';
    }

    public function createDtoFromResponse(Response $response): StatusData
    {
        return new StatusData(status: Status::SUCCESS);
    }
}
