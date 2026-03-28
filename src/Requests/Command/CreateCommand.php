<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Command;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use ThingsTelemetry\Traccar\Dto\CommandData;

class CreateCommand extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(public CommandData $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/commands';
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
