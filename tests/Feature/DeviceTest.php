<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\DeviceData;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Facades\Device;
use ThingsTelemetry\Traccar\Requests\Device\GetDevice;
use ThingsTelemetry\Traccar\Requests\Device\CreateDevice;
use ThingsTelemetry\Traccar\Requests\Device\DeleteDevice;
use ThingsTelemetry\Traccar\Requests\Device\UpdateDevice;
use ThingsTelemetry\Traccar\Requests\Device\GetAllDevices;
use ThingsTelemetry\Traccar\Requests\Device\GetForUserDevices;
use ThingsTelemetry\Traccar\Requests\Device\UpdateDeviceTotals;

$getDeviceData = fn () => [
    'id'       => 6,
    'name'     => 'Truck 1',
    'uniqueId' => 'ABC123',
    'status'   => 'online',
    'category' => 'truck',
];

test(description: 'can get all devices', closure: function () use ($getDeviceData) {
    MockClient::global(mockData: [
        GetAllDevices::class => MockResponse::make([$getDeviceData()]),
    ]);

    $response = Device::getAll();

    expect(value: $response)
        ->toBeInstanceOf(class: Collection::class)
        ->and(value: $response)->toHaveCount(count: 1);
});

test(description: 'can find a device by id', closure: function () use ($getDeviceData) {
    MockClient::global(mockData: [
        GetDevice::class => MockResponse::make($getDeviceData()),
    ]);

    $device = Device::find(id: 6);

    expect(value: $device)
        ->toBeInstanceOf(class: DeviceData::class)
        ->and(value: $device->id)->toEqual(expected: 6);
});

test(description: 'can get devices for a specific user', closure: function () use ($getDeviceData) {
    MockClient::global(mockData: [
        GetForUserDevices::class => MockResponse::make([$getDeviceData()]),
    ]);

    $response = Device::get(userId: 42);

    expect(value: $response)
        ->toBeInstanceOf(class: Collection::class)
        ->and(value: $response)->toHaveCount(count: 1);
});

test(description: 'can create a device', closure: function () use ($getDeviceData) {
    MockClient::global(mockData: [
        CreateDevice::class => MockResponse::make($getDeviceData()),
    ]);

    $data = DeviceData::fromArray(data: $getDeviceData());
    $response = Device::create(data: $data);

    expect(value: $response)
        ->toBeInstanceOf(class: DeviceData::class)
        ->and(value: $response->id)->toBe(6);
});

test(description: 'can update a device', closure: function () use ($getDeviceData) {
    MockClient::global(mockData: [
        UpdateDevice::class => MockResponse::make($getDeviceData()),
    ]);

    $data = DeviceData::fromArray(data: $getDeviceData());
    $response = Device::update(data: $data);

    expect(value: $response)
        ->toBeInstanceOf(class: DeviceData::class)
        ->and(value: $response->id)->toBe(6);
});

test(description: 'can delete a device', closure: function () {
    MockClient::global(mockData: [
        DeleteDevice::class => MockResponse::make(body: '', status: 204),
    ]);

    $result = Device::delete(id: 6);

    expect(value: $result)
        ->toBeInstanceOf(class: StatusData::class)
        ->and(value: $result->status)->toEqual(expected: Status::SUCCESS);
});

test(description: 'can update device totals', closure: function () {
    MockClient::global(mockData: [
        UpdateDeviceTotals::class => MockResponse::make(body: '', status: 204),
    ]);

    $result = Device::updateTotals(deviceId: 6, totalDistance: 12345.6, hours: 789.0);

    expect(value: $result)
        ->toBeInstanceOf(class: StatusData::class)
        ->and(value: $result->status)->toEqual(expected: Status::SUCCESS);
});
