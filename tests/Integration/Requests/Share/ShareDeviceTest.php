<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\DeviceShareData;
use ThingsTelemetry\Traccar\Requests\Share\ShareDevice;

test(description: 'it can share a device', closure: function () {
    $deviceId = 6;
    $expiration = CarbonImmutable::now()->addDay();
    $token = 'share-token-123';

    $mockClient = new MockClient(mockData: [
        ShareDevice::class => MockResponse::make(body: $token, status: 200),
    ]);

    $request = new ShareDevice(deviceId: $deviceId, expiration: $expiration);
    $response = connector()->send(request: $request, mockClient: $mockClient);

    expect(value: $response->dto())
        ->toBeInstanceOf(class: DeviceShareData::class)
        ->and(value: $response->dto()->deviceId)->toBe($deviceId)
        ->and(value: $response->dto()->token)->toBe($token);
});
