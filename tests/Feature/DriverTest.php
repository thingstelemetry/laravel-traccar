<?php

declare(strict_types=1);

use Saloon\Enums\Method;
use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\DriverData;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Facades\Driver;
use ThingsTelemetry\Traccar\Requests\Driver\CreateDriver;
use ThingsTelemetry\Traccar\Requests\Driver\DeleteDriver;
use ThingsTelemetry\Traccar\Requests\Driver\UpdateDriver;
use ThingsTelemetry\Traccar\Requests\Driver\GetAllDrivers;

$getDriverData = fn () => [
    'id'       => 9,
    'name'     => 'John Doe',
    'uniqueId' => 'DRV-001',
];

describe(description: 'all', tests: function () use ($getDriverData) {
    test(description: 'request sends the correct query parameters', closure: function () {
        $request = new GetAllDrivers(all: true, userId: 3, deviceId: 6, groupId: 4, refresh: true, limit: 10, offset: 2, keyword: 'john');

        expect(value: $request->resolveEndpoint())->toBe(expected: '/drivers')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET)
            ->and(value: $request->query()->all())->toBe(expected: [
                'all'      => true,
                'userId'   => 3,
                'deviceId' => 6,
                'groupId'  => 4,
                'refresh'  => true,
                'limit'    => 10,
                'offset'   => 2,
                'keyword'  => 'john',
            ]);
    });

    test(description: 'returns all drivers', closure: function () use ($getDriverData) {
        MockClient::global(mockData: [
            GetAllDrivers::class => MockResponse::make([$getDriverData()]),
        ]);

        $response = Driver::all();

        expect(value: $response)
            ->toBeInstanceOf(class: Collection::class)
            ->and(value: $response->first())->toBeInstanceOf(class: DriverData::class);
    });

    test(description: 'throws an exception on server error', closure: function () {
        MockClient::global(mockData: [
            GetAllDrivers::class => MockResponse::make(body: [], status: 500),
        ]);

        expect(value: fn () => Driver::all())
            ->toThrow(exception: \Saloon\Exceptions\Request\RequestException::class);
    });
});

describe(description: 'create', tests: function () use ($getDriverData) {
    test(description: 'request sends the correct body', closure: function () use ($getDriverData) {
        $data = DriverData::fromArray(data: $getDriverData());
        $request = new CreateDriver(data: $data);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/drivers')
            ->and(value: $request->getMethod())->toBe(expected: Method::POST)
            ->and(value: $request->body()->all())->toBe(expected: $data->toArray());
    });

    test(description: 'creates a driver', closure: function () use ($getDriverData) {
        MockClient::global(mockData: [
            CreateDriver::class => MockResponse::make($getDriverData()),
        ]);

        $response = Driver::create(data: DriverData::fromArray(data: $getDriverData()));

        expect(value: $response)->toBeInstanceOf(class: DriverData::class);
    });

    test(description: 'throws an exception on validation error', closure: function () use ($getDriverData) {
        MockClient::global(mockData: [
            CreateDriver::class => MockResponse::make(body: [], status: 400),
        ]);

        expect(value: fn () => Driver::create(data: DriverData::fromArray(data: $getDriverData())))
            ->toThrow(exception: \Saloon\Exceptions\Request\RequestException::class);
    });
});

describe(description: 'update', tests: function () use ($getDriverData) {
    test(description: 'request sends the correct body', closure: function () use ($getDriverData) {
        $data = DriverData::fromArray(data: $getDriverData());
        $request = new UpdateDriver(data: $data);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/drivers/9')
            ->and(value: $request->getMethod())->toBe(expected: Method::PUT)
            ->and(value: $request->body()->all())->toBe(expected: $data->toArray());
    });

    test(description: 'updates a driver', closure: function () use ($getDriverData) {
        MockClient::global(mockData: [
            UpdateDriver::class => MockResponse::make($getDriverData()),
        ]);

        $response = Driver::update(data: DriverData::fromArray(data: $getDriverData()));

        expect(value: $response)->toBeInstanceOf(class: DriverData::class);
    });

    test(description: 'throws an exception on record not found', closure: function () use ($getDriverData) {
        MockClient::global(mockData: [
            UpdateDriver::class => MockResponse::make(body: [], status: 404),
        ]);

        expect(value: fn () => Driver::update(data: DriverData::fromArray(data: $getDriverData())))
            ->toThrow(exception: \Saloon\Exceptions\Request\RequestException::class);
    });
});

describe(description: 'delete', tests: function () {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new DeleteDriver(id: 9);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/drivers/9')
            ->and(value: $request->getMethod())->toBe(expected: Method::DELETE);
    });

    test(description: 'deletes a driver', closure: function () {
        MockClient::global(mockData: [
            DeleteDriver::class => MockResponse::make(body: '', status: 204),
        ]);

        $result = Driver::delete(id: 9);

        expect(value: $result)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
    });

    test(description: 'throws an exception on deletion error', closure: function () {
        MockClient::global(mockData: [
            DeleteDriver::class => MockResponse::make(body: [], status: 500),
        ]);

        expect(value: fn () => Driver::delete(id: 9))
            ->toThrow(exception: \Saloon\Exceptions\Request\RequestException::class);
    });
});
