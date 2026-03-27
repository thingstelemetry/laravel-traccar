<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Facades\Share;
use ThingsTelemetry\Traccar\Dto\GroupShareData;
use ThingsTelemetry\Traccar\Dto\DeviceShareData;
use ThingsTelemetry\Traccar\Requests\Share\ShareGroup;
use ThingsTelemetry\Traccar\Requests\Share\ShareDevice;

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

it(description: 'can share a device', closure: function () {
    MockClient::global(mockData: [
        ShareDevice::class => MockResponse::make('token-abc-123'),
    ]);

    $share = Share::device(deviceId: 6, expiration: CarbonImmutable::parse('2030-12-31T23:59:59Z'));

    expect(value: $share)
        ->toBeInstanceOf(class: DeviceShareData::class)
        ->and(value: $share->token)->toEqual(expected: 'token-abc-123')
        ->and(value: $share->deviceId)->toEqual(expected: 6)
        ->and(value: $share->expiration)->toBeInstanceOf(class: CarbonImmutable::class)
        ->and(value: $share->expiration->toIso8601String())->toEqual(expected: '2030-12-31T23:59:59+00:00')
        ->and(value: $share->url)->toContain('/?token=token-abc-123');
});

it(description: 'can share a group', closure: function () {
    MockClient::global(mockData: [
        ShareGroup::class => MockResponse::make('token-abc-123'),
    ]);

    $share = Share::group(groupId: 6, expiration: CarbonImmutable::parse('2030-12-31T23:59:59Z'));

    expect(value: $share)
        ->toBeInstanceOf(class: GroupShareData::class)
        ->and(value: $share->token)->toEqual(expected: 'token-abc-123')
        ->and(value: $share->groupId)->toEqual(expected: 6)
        ->and(value: $share->expiration)->toBeInstanceOf(class: CarbonImmutable::class)
        ->and(value: $share->expiration->toIso8601String())->toEqual(expected: '2030-12-31T23:59:59+00:00')
        ->and(value: $share->url)->toContain('/?token=token-abc-123');
});
