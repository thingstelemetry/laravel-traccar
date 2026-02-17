<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\DeviceData;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Facades\Device;
use Illuminate\Validation\ValidationException;
use ThingsTelemetry\Traccar\Enums\DeviceStatus;
use ThingsTelemetry\Traccar\Dto\DeviceShareData;
use ThingsTelemetry\Traccar\Enums\DeviceCategory;
use ThingsTelemetry\Traccar\Dto\DeviceAttributesData;
use ThingsTelemetry\Traccar\Requests\Device\ShareDevice;
use ThingsTelemetry\Traccar\Requests\Device\CreateDevice;
use ThingsTelemetry\Traccar\Requests\Device\DeleteDevice;
use ThingsTelemetry\Traccar\Requests\Device\UpdateDevice;
use ThingsTelemetry\Traccar\Requests\Device\GetAllDevices;
use ThingsTelemetry\Traccar\Requests\Device\GetForUserDevices;
use ThingsTelemetry\Traccar\Requests\Device\UpdateDeviceImage;
use ThingsTelemetry\Traccar\Requests\Device\UpdateDeviceTotals;

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
    $response = Device::get(userId: $userId);

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

it(description: 'can get devices by ids', closure: function () {
    MockClient::global(mockData: [
        GetForUserDevices::class => MockResponse::make($this->devices),
    ]);

    $response = Device::get(ids: [6, 7]);

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

it(description: 'can get devices by uniqueIds', closure: function () {
    MockClient::global(mockData: [
        GetForUserDevices::class => MockResponse::make($this->devices),
    ]);

    $response = Device::get(uniqueIds: ['ABC123', 'XYZ789']);

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

it(description: 'can get devices with combined filters', closure: function () {
    MockClient::global(mockData: [
        GetForUserDevices::class => MockResponse::make($this->devices),
    ]);

    $response = Device::get(userId: 42, ids: [6], uniqueIds: ['XYZ789']);

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

it(description: 'can create a device', closure: function () {
    $created = [
        'name'       => 'My Vehicle',
        'uniqueId'   => '8346436046093',
        'status'     => DeviceStatus::UNKNOWN->value,
        'disabled'   => false,
        'lastUpdate' => null,
        'groupId'    => 0,
        'phone'      => null,
        'model'      => 'Teltonika FMB920',
        'category'   => DeviceCategory::CAR->value,
        'attributes' => [
            'speedLimit'            => 80,
            'fuelDropThreshold'     => 5.0,
            'fuelIncreaseThreshold' => 10,
        ],
    ];

    MockClient::global(mockData: [
        CreateDevice::class => MockResponse::make($created),
    ]);

    $attributes = new DeviceAttributesData(
        speedLimit: $created['attributes']['speedLimit'],
        fuelDropThreshold: $created['attributes']['fuelDropThreshold'],
        fuelIncreaseThreshold: $created['attributes']['fuelIncreaseThreshold'],
    );

    $requestData = DeviceData::fromArray(data: $created);

    $response = Device::create(data: $requestData);

    expect(value: $response)
        ->toBeInstanceOf(class: DeviceData::class)
        ->and(value: $response->status)->toEqual(expected: DeviceStatus::UNKNOWN)
        ->and(value: $response->category)->toEqual(expected: DeviceCategory::CAR)
        ->and(value: $response->attributes->speedLimit)->toBeFloat();
});

it(description: 'can update a device', closure: function () {
    $updated = [
        'id'         => 6,
        'name'       => 'Truck 1 - Updated',
        'uniqueId'   => 'ABC123',
        'status'     => DeviceStatus::ONLINE->value,
        'disabled'   => false,
        'lastUpdate' => '2019-08-24T14:15:22Z',
        'positionId' => 123,
        'groupId'    => 1,
        'phone'      => '+123456789',
        'model'      => 'TK103',
        'contact'    => 'Ops',
        'category'   => DeviceCategory::TRUCK->value,
        'attributes' => [
            'speedLimit' => 90.0,
        ],
    ];

    MockClient::global(mockData: [
        UpdateDevice::class => MockResponse::make($updated),
    ]);

    $data = DeviceData::fromArray(data: $updated);

    $response = Device::update(data: $data);

    expect(value: $response)
        ->toBeInstanceOf(class: DeviceData::class)
        ->and(value: $response->name)->toEqual(expected: 'Truck 1 - Updated')
        ->and(value: $response->attributes->speedLimit)->toBeFloat();
});

it(description: 'can delete a device', closure: function () {
    MockClient::global(mockData: [
        DeleteDevice::class => MockResponse::make(body: '', status: 204),
    ]);

    $result = Device::delete(id: 6);

    expect(value: $result)
        ->toBeInstanceOf(class: StatusData::class)
        ->and(value: $result->status)->toEqual(expected: Status::SUCCESS);
});

it(description: 'can share a device', closure: function () {
    MockClient::global(mockData: [
        ShareDevice::class => MockResponse::make('token-abc-123'),
    ]);

    $share = Device::share(deviceId: 6, expiration: CarbonImmutable::parse('2030-12-31T23:59:59Z'));

    expect(value: $share)
        ->toBeInstanceOf(class: DeviceShareData::class)
        ->and(value: $share->token)->toEqual(expected: 'token-abc-123')
        ->and(value: $share->deviceId)->toEqual(expected: 6)
        ->and(value: $share->expiration)->toBeInstanceOf(class: CarbonImmutable::class)
        ->and(value: $share->expiration->toIso8601String())->toEqual(expected: '2030-12-31T23:59:59+00:00')
        ->and(value: $share->url)->toContain('/?token=token-abc-123');
});

it(description: 'can upload a device image', closure: function () {
    MockClient::global(mockData: [
        UpdateDeviceImage::class => MockResponse::make('device.png'),
    ]);

    $uploaded = UploadedFile::fake()->image(name: 'device.png', width: 1, height: 1);

    $filename = Device::updateImage(deviceId: 6, file: $uploaded);

    expect(value: $filename)
        ->toBeString()
        ->toEqual(expected: 'device.png');
});

it(description: 'rejects non-image mime types when uploading device image', closure: function () {
    $uploaded = UploadedFile::fake()->create(name: 'notes.txt', kilobytes: 1, mimeType: 'text/plain');

    expect(value: fn () => Device::updateImage(deviceId: 6, file: $uploaded))
        ->toThrow(exception: ValidationException::class);
});

it(description: 'rejects image larger than 500 KB', closure: function () {
    // 501 KB = 513,024 bytes, which exceeds the 500 KB (512,000 bytes) limit
    $uploaded = UploadedFile::fake()->create(name: 'large.png', kilobytes: 501, mimeType: 'image/png');

    expect(value: fn () => Device::updateImage(deviceId: 6, file: $uploaded))
        ->toThrow(exception: ValidationException::class);
});

it(description: 'can update device totals (distance and hours)', closure: function () {
    MockClient::global(mockData: [
        UpdateDeviceTotals::class => MockResponse::make(body: '', status: 204),
    ]);

    $result = Device::updateTotals(deviceId: 6, totalDistance: 12345.6, hours: 789.0);

    expect(value: $result)
        ->toBeInstanceOf(class: StatusData::class)
        ->and(value: $result->status)->toEqual(expected: Status::SUCCESS);
});
