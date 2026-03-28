<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Attribute;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use ThingsTelemetry\Traccar\Dto\AttributeData;

class TestAttribute extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        public int $deviceId,
        public AttributeData $data,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/attributes/computed/test';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return $response->json();
    }

    /** @return array<string, mixed> */
    protected function defaultQuery(): array
    {
        return [
            'deviceId' => $this->deviceId,
        ];
    }

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }
}
