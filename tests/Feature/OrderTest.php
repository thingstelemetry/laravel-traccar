<?php

declare(strict_types=1);

use Saloon\Enums\Method;
use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\OrderData;
use ThingsTelemetry\Traccar\Facades\Order;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Requests\Order\CreateOrder;
use ThingsTelemetry\Traccar\Requests\Order\DeleteOrder;
use ThingsTelemetry\Traccar\Requests\Order\UpdateOrder;
use ThingsTelemetry\Traccar\Requests\Order\GetAllOrders;

$getOrderData = fn () => [
    'id'          => 13,
    'uniqueId'    => 'ORD-1001',
    'description' => 'Deliver package',
    'fromAddress' => 'Warehouse',
    'toAddress'   => 'Customer',
];

describe(description: 'get all', tests: function () use ($getOrderData) {
    test(description: 'request sends the correct query parameters', closure: function () {
        $request = new GetAllOrders(all: true, userId: 8, excludeAttributes: true, limit: 10, offset: 5, keyword: 'deliver');

        expect(value: $request->resolveEndpoint())->toBe(expected: '/orders')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET)
            ->and(value: $request->query()->all())->toBe(expected: [
                'all'               => true,
                'userId'            => 8,
                'excludeAttributes' => true,
                'limit'             => 10,
                'offset'            => 5,
                'keyword'           => 'deliver',
            ]);
    });

    test(description: 'returns all orders', closure: function () use ($getOrderData) {
        MockClient::global(mockData: [
            GetAllOrders::class => MockResponse::make([$getOrderData()]),
        ]);

        $response = Order::getAll();

        expect(value: $response)
            ->toBeInstanceOf(class: Collection::class)
            ->and(value: $response->first())->toBeInstanceOf(class: OrderData::class);
    });
});

describe(description: 'create', tests: function () use ($getOrderData) {
    test(description: 'request sends the correct body', closure: function () use ($getOrderData) {
        $data = OrderData::fromArray(data: $getOrderData());
        $request = new CreateOrder(data: $data);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/orders')
            ->and(value: $request->getMethod())->toBe(expected: Method::POST)
            ->and(value: $request->body()->all())->toBe(expected: $data->toArray());
    });

    test(description: 'creates an order', closure: function () use ($getOrderData) {
        MockClient::global(mockData: [
            CreateOrder::class => MockResponse::make($getOrderData()),
        ]);

        $response = Order::create(data: OrderData::fromArray(data: $getOrderData()));

        expect(value: $response)->toBeInstanceOf(class: OrderData::class);
    });
});

describe(description: 'update', tests: function () use ($getOrderData) {
    test(description: 'request sends the correct body', closure: function () use ($getOrderData) {
        $data = OrderData::fromArray(data: $getOrderData());
        $request = new UpdateOrder(data: $data);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/orders/13')
            ->and(value: $request->getMethod())->toBe(expected: Method::PUT)
            ->and(value: $request->body()->all())->toBe(expected: $data->toArray());
    });

    test(description: 'updates an order', closure: function () use ($getOrderData) {
        MockClient::global(mockData: [
            UpdateOrder::class => MockResponse::make($getOrderData()),
        ]);

        $response = Order::update(data: OrderData::fromArray(data: $getOrderData()));

        expect(value: $response)->toBeInstanceOf(class: OrderData::class);
    });
});

describe(description: 'delete', tests: function () {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new DeleteOrder(id: 13);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/orders/13')
            ->and(value: $request->getMethod())->toBe(expected: Method::DELETE);
    });

    test(description: 'deletes an order', closure: function () {
        MockClient::global(mockData: [
            DeleteOrder::class => MockResponse::make(body: '', status: 204),
        ]);

        $result = Order::delete(id: 13);

        expect(value: $result)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
    });
});
