<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Order;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use ThingsTelemetry\Traccar\Dto\OrderData;

class CreateOrder extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(public OrderData $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/orders';
    }

    public function createDtoFromResponse(Response $response): OrderData
    {
        return OrderData::fromArray(data: $response->json());
    }

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }
}
