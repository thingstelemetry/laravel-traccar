<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Order;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use InvalidArgumentException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use ThingsTelemetry\Traccar\Dto\OrderData;

class UpdateOrder extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

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

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }
}
