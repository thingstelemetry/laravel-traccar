<?php

declare(strict_types=1);

use Saloon\Enums\Method;
use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\DeviceData;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Facades\Device;
use ThingsTelemetry\Traccar\Requests\Device\GetDevice;
use Saloon\Exceptions\Request\Statuses\NotFoundException;
use ThingsTelemetry\Traccar\Requests\Device\CreateDevice;
use ThingsTelemetry\Traccar\Requests\Device\DeleteDevice;
use ThingsTelemetry\Traccar\Requests\Device\UpdateDevice;
use ThingsTelemetry\Traccar\Requests\Device\GetAllDevices;
use ThingsTelemetry\Traccar\Requests\Device\UpdateDeviceTotals;

$getDeviceData = fn () => [
    'id'       => 6,
    'name'     => 'Truck 1',
    'uniqueId' => 'ABC123',
    'status'   => 'online',
    'category' => 'truck',
];

describe(description: 'all', tests: function () use ($getDeviceData) {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new GetAllDevices();

        expect(value: $request->resolveEndpoint())->toBe(expected: '/devices')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET);
    });

    test(description: 'returns all devices', closure: function () use ($getDeviceData) {
        MockClient::global(mockData: [
            GetAllDevices::class => MockResponse::make([$getDeviceData()]),
        ]);

        $response = Device::all();

        expect(value: $response)
            ->toBeInstanceOf(class: Collection::class)
            ->and(value: $response)->toHaveCount(count: 1);
    });
});

describe(description: 'find', tests: function () use ($getDeviceData) {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new GetDevice(id: 6);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/devices/6')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET);
    });

    test(description: 'returns a device by id', closure: function () use ($getDeviceData) {
        MockClient::global(mockData: [
            GetDevice::class => MockResponse::make($getDeviceData()),
        ]);

        $device = Device::find(id: 6);

        expect(value: $device)
            ->toBeInstanceOf(class: DeviceData::class)
            ->and(value: $device->id)->toBe(expected: 6);
    });

    test(description: 'throws not found when the device response is empty', closure: function () {
        MockClient::global(mockData: [
            GetDevice::class => MockResponse::make(body: [], status: 200),
        ]);

        expect(value: fn () => Device::find(id: 999))
            ->toThrow(exception: NotFoundException::class, exceptionMessage: 'Traccar device was not found. Check the device ID and try again.');
    });
});

describe(description: 'all with filters', tests: function () use ($getDeviceData) {
    test(description: 'request resolves the correct endpoint and query params', closure: function () {
        $request = new GetAllDevices(
            userId: 42,
            ids: [1, 2],
            uniqueIds: ['U1', 'U2'],
            all: true,
            excludeAttributes: true,
            limit: 10,
            offset: 20,
            keyword: 'truck'
        );

        expect(value: $request->resolveEndpoint())->toBe(expected: '/devices')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET)
            ->and(value: $request->query()->all())->toBe(expected: [
                'userId'            => 42,
                'id'                => [1, 2],
                'uniqueId'          => ['U1', 'U2'],
                'all'               => true,
                'excludeAttributes' => true,
                'limit'             => 10,
                'offset'            => 20,
                'keyword'           => 'truck',
            ]);
    });

    test(description: 'returns devices for a specific user via facade', closure: function () use ($getDeviceData) {
        MockClient::global(mockData: [
            GetAllDevices::class => MockResponse::make([$getDeviceData()]),
        ]);

        $response = Device::all(userId: 42);

        expect(value: $response)
            ->toBeInstanceOf(class: Collection::class)
            ->and(value: $response)->toHaveCount(count: 1);
    });
});

describe(description: 'create', tests: function () use ($getDeviceData) {
    test(description: 'request sends the correct body', closure: function () use ($getDeviceData) {
        $data = DeviceData::fromArray(data: $getDeviceData());
        $request = new CreateDevice(data: $data);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/devices')
            ->and(value: $request->getMethod())->toBe(expected: Method::POST)
            ->and(value: $request->body()->all())->toBe(expected: $data->toArray());
    });

    test(description: 'creates a device', closure: function () use ($getDeviceData) {
        MockClient::global(mockData: [
            CreateDevice::class => MockResponse::make($getDeviceData()),
        ]);

        $data = DeviceData::fromArray(data: $getDeviceData());
        $response = Device::create(data: $data);

        expect(value: $response)
            ->toBeInstanceOf(class: DeviceData::class)
            ->and(value: $response->id)->toBe(expected: 6);
    });
});

describe(description: 'update', tests: function () use ($getDeviceData) {
    test(description: 'request sends the correct body', closure: function () use ($getDeviceData) {
        $data = DeviceData::fromArray(data: $getDeviceData());
        $request = new UpdateDevice(data: $data);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/devices/6')
            ->and(value: $request->getMethod())->toBe(expected: Method::PUT)
            ->and(value: $request->body()->all())->toBe(expected: $data->toArray());
    });

    test(description: 'updates a device', closure: function () use ($getDeviceData) {
        MockClient::global(mockData: [
            UpdateDevice::class => MockResponse::make($getDeviceData()),
        ]);

        $data = DeviceData::fromArray(data: $getDeviceData());
        $response = Device::update(data: $data);

        expect(value: $response)
            ->toBeInstanceOf(class: DeviceData::class)
            ->and(value: $response->id)->toBe(expected: 6);
    });
});

describe(description: 'delete', tests: function () {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new DeleteDevice(id: 6);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/devices/6')
            ->and(value: $request->getMethod())->toBe(expected: Method::DELETE);
    });

    test(description: 'deletes a device', closure: function () {
        MockClient::global(mockData: [
            DeleteDevice::class => MockResponse::make(body: '', status: 204),
        ]);

        $result = Device::delete(id: 6);

        expect(value: $result)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
    });
});

describe(description: 'update totals', tests: function () {
    test(description: 'request sends the correct body', closure: function () {
        $request = new UpdateDeviceTotals(deviceId: 6, totalDistance: 12345.6, hours: 789.0);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/devices/6/accumulators')
            ->and(value: $request->getMethod())->toBe(expected: Method::PUT)
            ->and(value: $request->body()->all())->toBe(expected: [
                'deviceId'      => 6,
                'totalDistance' => 12345.6,
                'hours'         => 789.0,
            ]);
    });

    test(description: 'updates device totals', closure: function () {
        MockClient::global(mockData: [
            UpdateDeviceTotals::class => MockResponse::make(body: '', status: 204),
        ]);

        $result = Device::updateTotals(deviceId: 6, totalDistance: 12345.6, hours: 789.0);

        expect(value: $result)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
    });
});
