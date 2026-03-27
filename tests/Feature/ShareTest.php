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

test(description: 'can share a device', closure: function () {
    MockClient::global(mockData: [
        ShareDevice::class => MockResponse::make('token-abc-123'),
    ]);

    $share = Share::device(deviceId: 6, expiration: CarbonImmutable::parse('2030-12-31T23:59:59Z'));

    expect(value: $share)
        ->toBeInstanceOf(class: DeviceShareData::class)
        ->and(value: $share->token)->toEqual(expected: 'token-abc-123')
        ->and(value: $share->deviceId)->toEqual(expected: 6);
});

test(description: 'can share a group', closure: function () {
    MockClient::global(mockData: [
        ShareGroup::class => MockResponse::make('token-abc-123'),
    ]);

    $share = Share::group(groupId: 6, expiration: CarbonImmutable::parse('2030-12-31T23:59:59Z'));

    expect(value: $share)
        ->toBeInstanceOf(class: GroupShareData::class)
        ->and(value: $share->token)->toEqual(expected: 'token-abc-123')
        ->and(value: $share->groupId)->toEqual(expected: 6);
});
