<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\Device;

use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\DeviceData;
use ThingsTelemetry\Traccar\TraccarConnector;
use ThingsTelemetry\Traccar\Requests\Device\GetAllDevices;

beforeEach(closure: function () {
    $this->connector = new TraccarConnector(
        baseUrl: 'https://demo.traccar.org/api',
        apiKey: 'test-api-key'
    );
});

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new GetAllDevices();

    expect(value: $request->resolveEndpoint())->toBe(expected: '/devices')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'GET');
});

test(description: 'it creates a collection of DeviceData DTOs from response via createDtoFromResponse', closure: function () {
    $payload = [
        [
            'id'       => 6,
            'name'     => 'Truck 1',
            'uniqueId' => 'ABC123',
        ],
    ];

    $mockClient = new MockClient(mockData: [
        GetAllDevices::class => MockResponse::make(body: $payload, status: 200),
    ]);

    $request = new GetAllDevices();
    $response = $this->connector->send(request: $request, mockClient: $mockClient);

    $devices = $response->dtoOrFail();

    expect(value: $devices)->toBeInstanceOf(class: Collection::class)
        ->and(value: $devices)->toHaveCount(1)
        ->and(value: $devices->first())->toBeInstanceOf(class: DeviceData::class);
});
