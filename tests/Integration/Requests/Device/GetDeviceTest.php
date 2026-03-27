<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\Device;

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\DeviceData;
use ThingsTelemetry\Traccar\TraccarConnector;
use ThingsTelemetry\Traccar\Requests\Device\GetDevice;
use Saloon\Exceptions\Request\Statuses\NotFoundException;

beforeEach(closure: function () {
    $this->connector = new TraccarConnector(
        baseUrl: 'https://demo.traccar.org/api',
        apiKey: 'test-api-key'
    );
});

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new GetDevice(id: 6);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/devices/6')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'GET');
});

test(description: 'it creates a DeviceData DTO from response via createDtoFromResponse', closure: function () {
    $body = [
        'id'         => 6,
        'name'       => 'Truck 1',
        'uniqueId'   => 'ABC123',
        'status'     => 'online',
        'disabled'   => false,
        'lastUpdate' => '2019-08-24T14:15:22Z',
        'positionId' => 123,
        'groupId'    => 1,
        'phone'      => '+123456789',
        'model'      => 'TK103',
        'contact'    => 'Ops',
        'category'   => 'truck',
        'attributes' => [
            'speedLimit' => 80.0,
        ],
    ];

    $mockClient = new MockClient(mockData: [
        GetDevice::class => MockResponse::make(body: $body, status: 200),
    ]);

    $request = new GetDevice(id: 6);
    $response = $this->connector->send(request: $request, mockClient: $mockClient);

    $device = $response->dtoOrFail();

    expect(value: $device)->toBeInstanceOf(class: DeviceData::class)
        ->and(value: $device->id)->toBe(expected: 6);
});

test(description: 'it throws NotFoundException when device returns 200 with empty body via createDtoFromResponse', closure: function () {
    $mockClient = new MockClient(mockData: [
        GetDevice::class => MockResponse::make(body: [], status: 200),
    ]);

    $request = new GetDevice(id: 999);

    expect(value: fn () => $this->connector->send(request: $request, mockClient: $mockClient)->dtoOrFail())
        ->toThrow(exception: NotFoundException::class, exceptionMessage: 'Traccar device was not found. Check the device ID and try again.');
});
