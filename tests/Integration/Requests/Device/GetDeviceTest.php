<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\DeviceData;
use ThingsTelemetry\Traccar\Enums\DeviceStatus;
use ThingsTelemetry\Traccar\Enums\DeviceCategory;
use ThingsTelemetry\Traccar\Dto\DeviceAttributesData;
use ThingsTelemetry\Traccar\Requests\Device\GetDevice;
use Saloon\Exceptions\Request\Statuses\NotFoundException;

test(description: 'it can get a device by id', closure: function () {
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
        GetDevice::class => MockResponse::make(body: $body),
    ]);

    $request = new GetDevice(id: 6);
    $response = connector()->send(request: $request, mockClient: $mockClient);

    expect(value: $response->dto())
        ->toBeInstanceOf(class: DeviceData::class)
        ->and(value: $response->dto()->id)->toBe(6)
        ->and(value: $response->dto()->status)->toBe(DeviceStatus::ONLINE)
        ->and(value: $response->dto()->category)->toBe(DeviceCategory::TRUCK)
        ->and(value: $response->dto()->lastUpdate)->toBeInstanceOf(class: CarbonImmutable::class)
        ->and(value: $response->dto()->attributes)->toBeInstanceOf(class: DeviceAttributesData::class)
        ->and(value: $response->dto()->attributes->speedLimit)->toBe(80.0);
});

test(description: 'it throws NotFoundException when device returns 200 with empty body', closure: function () {
    $mockClient = new MockClient(mockData: [
        GetDevice::class => MockResponse::make(body: [], status: 200),
    ]);

    $request = new GetDevice(id: 999);

    expect(value: fn () => connector()->send(request: $request, mockClient: $mockClient)->dto())
        ->toThrow(exception: NotFoundException::class, message: 'Traccar device was not found. Check the device ID and try again.');
});

test(description: 'it throws NotFoundException when device returns HTTP 404', closure: function () {
    $mockClient = new MockClient(mockData: [
        GetDevice::class => MockResponse::make(body: ['error' => 'Not found'], status: 404),
    ]);

    $request = new GetDevice(id: 999);

    expect(value: fn () => connector()->send(request: $request, mockClient: $mockClient)->dto())
        ->toThrow(exception: NotFoundException::class);
});
