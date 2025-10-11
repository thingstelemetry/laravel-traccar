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
use TrackTelemetry\Traccar\Dto\DeviceAttributesData;

beforeEach(function () {
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

it('can get all devices', function () {
    MockClient::global([
        GetAllDevices::class => MockResponse::make($this->devices),
    ]);

    $response = Device::getAll();

    expect($response)
        ->toBeInstanceOf(Collection::class)
        ->and($response)->toHaveCount(2);

    $first = $response->first();
    expect($first)
        ->toBeInstanceOf(DeviceData::class)
        ->and($first->status)->toEqual(DeviceStatus::ONLINE)
        ->and($first->category)->toEqual(DeviceCategory::TRUCK)
        ->and($first->lastUpdate)->toBeInstanceOf(CarbonImmutable::class)
        ->and($first->attributes)->toBeInstanceOf(DeviceAttributesData::class)
        ->and($first->attributes->speedLimit)->toBeFloat();
});
