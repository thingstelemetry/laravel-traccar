<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Group;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use ThingsTelemetry\Traccar\Dto\GroupData;

class CreateGroup extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(public GroupData $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/groups';
    }

    /** @throws JsonException */
    public function createDtoFromResponse(Response $response): GroupData
    {
        return GroupData::fromArray(data: $response->json());
    }

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }
}
