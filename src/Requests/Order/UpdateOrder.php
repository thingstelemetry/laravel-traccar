<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Order;

use Saloon\Http\Response;
use InvalidArgumentException;
use ThingsTelemetry\Traccar\Dto\OrderData;
use ThingsTelemetry\Traccar\Requests\Abstract\UpdateRequest;

class UpdateOrder extends UpdateRequest
{
    public function __construct(public OrderData $data)
    {
        if (is_null($data->id)) {
            throw new InvalidArgumentException(message: 'Order ID is required for update operations.');
        }
    }

    public function resolveEndpoint(): string
    {
        return "/orders/{$this->data->id}";
    }

    public function createDtoFromResponse(Response $response): OrderData
    {
        return OrderData::fromArray(data: $response->json());
    }
}
