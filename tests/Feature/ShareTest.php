<?php

declare(strict_types=1);

use Saloon\Enums\Method;
use Carbon\CarbonImmutable;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Facades\Share;
use ThingsTelemetry\Traccar\Dto\GroupShareData;
use ThingsTelemetry\Traccar\Dto\DeviceShareData;
use ThingsTelemetry\Traccar\Requests\Share\ShareGroup;
use ThingsTelemetry\Traccar\Requests\Share\ShareDevice;

describe(description: 'device', tests: function () {
    test(description: 'request sends the correct body', closure: function () {
        $expiration = CarbonImmutable::parse('2030-12-31T23:59:59Z');
        $request = new ShareDevice(deviceId: 6, expiration: $expiration);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/share/device')
            ->and(value: $request->getMethod())->toBe(expected: Method::POST)
            ->and(value: $request->body()->all())->toBe(expected: [
                'deviceId'   => 6,
                'expiration' => $expiration->toIso8601String(),
            ]);
    });

    test(description: 'shares a device', closure: function () {
        MockClient::global(mockData: [
            ShareDevice::class => MockResponse::make('token-abc-123'),
        ]);

        $share = Share::device(deviceId: 6, expiration: CarbonImmutable::parse('2030-12-31T23:59:59Z'));

        expect(value: $share)
            ->toBeInstanceOf(class: DeviceShareData::class)
            ->and(value: $share->token)->toBe(expected: 'token-abc-123')
            ->and(value: $share->deviceId)->toBe(expected: 6);
    });

    test(description: 'shares a device with a quoted token', closure: function () {
        MockClient::global(mockData: [
            ShareDevice::class => MockResponse::make('"token-abc-123"'),
        ]);

        $share = Share::device(deviceId: 6, expiration: CarbonImmutable::parse('2030-12-31T23:59:59Z'));

        expect(value: $share)
            ->toBeInstanceOf(class: DeviceShareData::class)
            ->and(value: $share->token)->toBe(expected: 'token-abc-123');
    });
});

describe(description: 'group', tests: function () {
    test(description: 'request sends the correct body', closure: function () {
        $expiration = CarbonImmutable::parse('2030-12-31T23:59:59Z');
        $request = new ShareGroup(groupId: 6, expiration: $expiration);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/share/group')
            ->and(value: $request->getMethod())->toBe(expected: Method::POST)
            ->and(value: $request->body()->all())->toBe(expected: [
                'groupId'    => 6,
                'expiration' => $expiration->toIso8601String(),
            ]);
    });

    test(description: 'shares a group', closure: function () {
        MockClient::global(mockData: [
            ShareGroup::class => MockResponse::make('token-abc-123'),
        ]);

        $share = Share::group(groupId: 6, expiration: CarbonImmutable::parse('2030-12-31T23:59:59Z'));

        expect(value: $share)
            ->toBeInstanceOf(class: GroupShareData::class)
            ->and(value: $share->token)->toBe(expected: 'token-abc-123')
            ->and(value: $share->groupId)->toBe(expected: 6);
    });

    test(description: 'shares a group with a quoted token', closure: function () {
        MockClient::global(mockData: [
            ShareGroup::class => MockResponse::make('"token-abc-123"'),
        ]);

        $share = Share::group(groupId: 6, expiration: CarbonImmutable::parse('2030-12-31T23:59:59Z'));

        expect(value: $share)
            ->toBeInstanceOf(class: GroupShareData::class)
            ->and(value: $share->token)->toBe(expected: 'token-abc-123');
    });
});
