<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Command;

use Saloon\Http\Response;
use InvalidArgumentException;
use ThingsTelemetry\Traccar\Dto\CommandData;
use ThingsTelemetry\Traccar\Requests\Abstract\UpdateRequest;

class UpdateCommand extends UpdateRequest
{
    public function __construct(public CommandData $data)
    {
        if (is_null($data->id)) {
            throw new InvalidArgumentException(message: 'Command ID is required for update operations.');
        }
    }

    public function resolveEndpoint(): string
    {
        return "/commands/{$this->data->id}";
    }

    public function createDtoFromResponse(Response $response): CommandData
    {
        return CommandData::fromArray(data: $response->json());
    }
}
