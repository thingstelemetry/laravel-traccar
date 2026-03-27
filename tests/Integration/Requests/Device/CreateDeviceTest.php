<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\DeviceData;
use ThingsTelemetry\Traccar\Requests\Device\CreateDevice;

test(description: 'it can create a device', closure: function () {
    $payload = [
        'id'       => 6,
        'name'     => 'Truck 1',
        'uniqueId' => 'ABC123',
    ];

    $mockClient = new MockClient(mockData: [
        CreateDevice::class => MockResponse::make(body: $payload),
    ]);

    $data = DeviceData::fromArray($payload);
    $request = new CreateDevice(data: $data);
    $response = connector()->send(request: $request, mockClient: $mockClient);

    expect(value: $response->dto())
        ->toBeInstanceOf(class: DeviceData::class)
        ->and(value: $response->dto()->id)->toBe(6);
});
