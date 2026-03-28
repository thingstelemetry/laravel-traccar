<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\Device;

use ThingsTelemetry\Traccar\Dto\DeviceData;
use ThingsTelemetry\Traccar\Requests\Device\CreateDevice;

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

    expect(value: $request->body()->all())->toBe(expected: $data->toArray());
});
