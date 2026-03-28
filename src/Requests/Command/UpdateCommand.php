<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Command;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use InvalidArgumentException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use ThingsTelemetry\Traccar\Dto\CommandData;

class UpdateCommand extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

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

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }
}
