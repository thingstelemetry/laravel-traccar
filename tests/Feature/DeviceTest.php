<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use TrackTelemetry\Traccar\Dto\DeviceData;
use TrackTelemetry\Traccar\Facades\Device;
use TrackTelemetry\Traccar\Enums\DeviceStatus;
use TrackTelemetry\Traccar\Enums\DeviceCategory;
use TrackTelemetry\Traccar\Requests\GetAllDevices;
use TrackTelemetry\Traccar\Requests\GetForUserDevices;
use TrackTelemetry\Traccar\Dto\DeviceAttributesData;

beforeEach(closure: function () {
    $this->devices = [
        [
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
        ],
        [
            'id'         => 7,
            'name'       => 'Car 2',
            'uniqueId'   => 'XYZ789',
            'status'     => 'unknown',
            'disabled'   => true,
            'lastUpdate' => null,
            'positionId' => null,
            'groupId'    => null,
            'phone'      => null,
            'model'      => null,
            'contact'    => null,
            'category'   => 'car',
            'attributes' => [],
        ],
    ];
});

it(description: 'can get all devices', closure: function () {
    MockClient::global(mockData: [
        GetAllDevices::class => MockResponse::make($this->devices),
    ]);

    $response = Device::getAll();

    expect(value: $response)
        ->toBeInstanceOf(class: Collection::class)
        ->and(value: $response)->toHaveCount(count: 2);

    $first = $response->first();
    expect(value: $first)
        ->toBeInstanceOf(class: DeviceData::class)
        ->and(value: $first->status)->toEqual(expected: DeviceStatus::ONLINE)
        ->and(value: $first->category)->toEqual(expected: DeviceCategory::TRUCK)
        ->and(value: $first->lastUpdate)->toBeInstanceOf(class: CarbonImmutable::class)
        ->and(value: $first->attributes)->toBeInstanceOf(class: DeviceAttributesData::class)
        ->and(value: $first->attributes->speedLimit)->toBeFloat();
});

it(description: 'can get devices for a specific user', closure: function () {
    MockClient::global(mockData: [
        GetForUserDevices::class => MockResponse::make($this->devices),
    ]);

    $userId = 42;
    $response = Device::get($userId);

    expect(value: $response)
        ->toBeInstanceOf(class: Collection::class)
        ->and(value: $response)->toHaveCount(count: 2);

    $first = $response->first();
    expect(value: $first)
        ->toBeInstanceOf(class: DeviceData::class)
        ->and(value: $first->status)->toEqual(expected: DeviceStatus::ONLINE)
        ->and(value: $first->category)->toEqual(expected: DeviceCategory::TRUCK)
        ->and(value: $first->lastUpdate)->toBeInstanceOf(class: CarbonImmutable::class)
        ->and(value: $first->attributes)->toBeInstanceOf(class: DeviceAttributesData::class)
        ->and(value: $first->attributes->speedLimit)->toBeFloat();
});
