<?php

declare(strict_types=1);

use Saloon\Enums\Method;
use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Dto\AttributeData;
use ThingsTelemetry\Traccar\Facades\Attribute;
use ThingsTelemetry\Traccar\Requests\Attribute\CreateAttribute;
use ThingsTelemetry\Traccar\Requests\Attribute\DeleteAttribute;
use ThingsTelemetry\Traccar\Requests\Attribute\UpdateAttribute;
use ThingsTelemetry\Traccar\Requests\Attribute\GetAllAttributes;

$getAttributeData = fn () => [
    'id'          => 17,
    'description' => 'Overspeed',
    'attribute'   => 'overspeed',
    'expression'  => 'speed > 80',
    'type'        => 'Boolean',
];

describe(description: 'get all', tests: function () use ($getAttributeData) {
    test(description: 'request sends the correct query parameters', closure: function () {
        $request = new GetAllAttributes(all: true, userId: 3, deviceId: 6, groupId: 4, refresh: true, limit: 10, offset: 2, keyword: 'speed');

        expect(value: $request->resolveEndpoint())->toBe(expected: '/attributes/computed')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET)
            ->and(value: $request->query()->all())->toBe(expected: [
                'all'      => true,
                'userId'   => 3,
                'deviceId' => 6,
                'groupId'  => 4,
                'refresh'  => true,
                'limit'    => 10,
                'offset'   => 2,
                'keyword'  => 'speed',
            ]);
    });

    test(description: 'returns all attributes', closure: function () use ($getAttributeData) {
        MockClient::global(mockData: [
            GetAllAttributes::class => MockResponse::make([$getAttributeData()]),
        ]);

        $response = Attribute::getAll();

        expect(value: $response)
            ->toBeInstanceOf(class: Collection::class)
            ->and(value: $response->first())->toBeInstanceOf(class: AttributeData::class);
    });
});

describe(description: 'create', tests: function () use ($getAttributeData) {
    test(description: 'request sends the correct body', closure: function () use ($getAttributeData) {
        $data = AttributeData::fromArray(data: $getAttributeData());
        $request = new CreateAttribute(data: $data);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/attributes/computed')
            ->and(value: $request->getMethod())->toBe(expected: Method::POST)
            ->and(value: $request->body()->all())->toBe(expected: $data->toArray());
    });

    test(description: 'creates an attribute', closure: function () use ($getAttributeData) {
        MockClient::global(mockData: [
            CreateAttribute::class => MockResponse::make($getAttributeData()),
        ]);

        $response = Attribute::create(data: AttributeData::fromArray(data: $getAttributeData()));

        expect(value: $response)->toBeInstanceOf(class: AttributeData::class);
    });
});

describe(description: 'update', tests: function () use ($getAttributeData) {
    test(description: 'request sends the correct body', closure: function () use ($getAttributeData) {
        $data = AttributeData::fromArray(data: $getAttributeData());
        $request = new UpdateAttribute(data: $data);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/attributes/computed/17')
            ->and(value: $request->getMethod())->toBe(expected: Method::PUT)
            ->and(value: $request->body()->all())->toBe(expected: $data->toArray());
    });

    test(description: 'updates an attribute', closure: function () use ($getAttributeData) {
        MockClient::global(mockData: [
            UpdateAttribute::class => MockResponse::make($getAttributeData()),
        ]);

        $response = Attribute::update(data: AttributeData::fromArray(data: $getAttributeData()));

        expect(value: $response)->toBeInstanceOf(class: AttributeData::class);
    });
});

describe(description: 'delete', tests: function () {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new DeleteAttribute(id: 17);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/attributes/computed/17')
            ->and(value: $request->getMethod())->toBe(expected: Method::DELETE);
    });

    test(description: 'deletes an attribute', closure: function () {
        MockClient::global(mockData: [
            DeleteAttribute::class => MockResponse::make(body: '', status: 204),
        ]);

        $result = Attribute::delete(id: 17);

        expect(value: $result)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
    });
});
