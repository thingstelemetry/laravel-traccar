<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Command;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;

class DeleteCommand extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(public int $id)
    {
    }

    public function resolveEndpoint(): string
    {
        return "/commands/{$this->id}";
    }

    public function createDtoFromResponse(Response $response): StatusData
    {
        return new StatusData(status: Status::SUCCESS);
    }
}
