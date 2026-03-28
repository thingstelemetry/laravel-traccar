<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Order;

use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Dto\OrderData;
use ThingsTelemetry\Traccar\Requests\Abstract\CreateRequest;

class CreateOrder extends CreateRequest
{
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
}
