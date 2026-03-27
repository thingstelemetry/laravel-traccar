<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\Device;

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\DeviceData;
use ThingsTelemetry\Traccar\TraccarConnector;
use ThingsTelemetry\Traccar\Requests\Device\CreateDevice;

beforeEach(closure: function () {
    $this->connector = new TraccarConnector(
        baseUrl: 'https://demo.traccar.org/api',
        apiKey: 'test-api-key'
    );
});

test(description: 'it resolves the correct endpoint', closure: function () {
    $payload = [
        'id'       => 6,
        'name'     => 'Truck 1',
        'uniqueId' => 'ABC123',
    ];

    $data = DeviceData::fromArray($payload);
    $request = new CreateDevice(data: $data);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/devices')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'POST');
});

test(description: 'it sends the correct body', closure: function () {
    $payload = [
        'id'       => 6,
        'name'     => 'Truck 1',
        'uniqueId' => 'ABC123',
    ];

    $data = DeviceData::fromArray($payload);
    $request = new CreateDevice(data: $data);

    expect(value: $request->body()->all())->toBe(expected: $payload);
});

test(description: 'it creates a DeviceData DTO from response via createDtoFromResponse', closure: function () {
    $payload = [
        'id'       => 6,
        'name'     => 'Truck 1',
        'uniqueId' => 'ABC123',
    ];

    $mockClient = new MockClient(mockData: [
        CreateDevice::class => MockResponse::make(body: $payload, status: 200),
    ]);

    $data = DeviceData::fromArray($payload);
    $request = new CreateDevice(data: $data);
    $response = $this->connector->send(request: $request, mockClient: $mockClient);

    $device = $response->dtoOrFail();

    expect(value: $device)->toBeInstanceOf(class: DeviceData::class)
        ->and(value: $device->id)->toBe(expected: 6);
});
