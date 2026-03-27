<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\DeviceData;
use ThingsTelemetry\Traccar\Requests\Device\GetAllDevices;

test(description: 'it can get all devices', closure: function () {
    $payload = [
        [
            'id'       => 6,
            'name'     => 'Truck 1',
            'uniqueId' => 'ABC123',
        ],
    ];

    $mockClient = new MockClient(mockData: [
        GetAllDevices::class => MockResponse::make(body: $payload),
    ]);

    $request = new GetAllDevices();
    $response = connector()->send(request: $request, mockClient: $mockClient);

    expect(value: $response->dto())
        ->toBeInstanceOf(class: Collection::class)
        ->and(value: $response->dto())->toHaveCount(1)
        ->and(value: $response->dto()->first())->toBeInstanceOf(class: DeviceData::class);
});
