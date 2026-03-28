<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Dto\OrderData;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Requests\Order\CreateOrder;
use ThingsTelemetry\Traccar\Requests\Order\DeleteOrder;
use ThingsTelemetry\Traccar\Requests\Order\UpdateOrder;
use ThingsTelemetry\Traccar\Requests\Order\GetAllOrders;

class Order extends Traccar
{
    /** @throws \Saloon\Exceptions\SaloonException */
    public function getAll(?bool $all = null, ?int $userId = null, ?bool $excludeAttributes = null, ?int $limit = null, ?int $offset = null, ?string $keyword = null): Collection
    {
        $response = $this->connector->send(
            request: new GetAllOrders(
                all: $all,
                userId: $userId,
                excludeAttributes: $excludeAttributes,
                limit: $limit,
                offset: $offset,
                keyword: $keyword,
            )
        );

        return $response->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function create(OrderData $data): OrderData
    {
        return $this->connector->send(request: new CreateOrder(data: $data))->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function update(OrderData $data): OrderData
    {
        return $this->connector->send(request: new UpdateOrder(data: $data))->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function delete(int $id): StatusData
    {
        return $this->connector->send(request: new DeleteOrder(id: $id))->dtoOrFail();
    }
}
