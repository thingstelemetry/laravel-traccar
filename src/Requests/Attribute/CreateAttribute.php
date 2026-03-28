<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Attribute;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use ThingsTelemetry\Traccar\Dto\AttributeData;

class CreateAttribute extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(public AttributeData $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/attributes/computed';
    }

    public function createDtoFromResponse(Response $response): AttributeData
    {
        return AttributeData::fromArray(data: $response->json());
    }

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }
}
