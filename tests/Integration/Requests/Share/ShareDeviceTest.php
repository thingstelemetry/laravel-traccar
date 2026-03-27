<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\TraccarConnector;
use ThingsTelemetry\Traccar\Dto\DeviceShareData;
use ThingsTelemetry\Traccar\Requests\Share\ShareDevice;

beforeEach(closure: function () {
    $this->connector = new TraccarConnector(
        baseUrl: 'https://demo.traccar.org/api',
        apiKey: 'test-api-key'
    );
});

test(description: 'it resolves the correct endpoint', closure: function () {
    $expiration = CarbonImmutable::parse('2026-12-01T12:00:00Z');
    $request = new ShareDevice(deviceId: 6, expiration: $expiration);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/devices/6/share')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'GET');
});

test(description: 'it sends the correct query parameters', closure: function () {
    $expiration = CarbonImmutable::parse('2026-12-01T12:00:00Z');
    $request = new ShareDevice(deviceId: 6, expiration: $expiration);

    expect(value: $request->query()->get(key: 'expiration'))->toBe(expected: $expiration->toIso8601String());
});

test(description: 'it creates a DeviceShareData DTO from response via createDtoFromResponse', closure: function () {
    $deviceId = 6;
    $expiration = CarbonImmutable::parse('2026-12-01T12:00:00Z');
    $token = 'share-token-123';

    $mockClient = new MockClient(mockData: [
        ShareDevice::class => MockResponse::make(body: $token, status: 200),
    ]);

    $request = new ShareDevice(deviceId: $deviceId, expiration: $expiration);
    $response = $this->connector->send(request: $request, mockClient: $mockClient);

    $share = $response->dtoOrFail();

    expect(value: $share)->toBeInstanceOf(class: DeviceShareData::class)
        ->and(value: $share->deviceId)->toBe(expected: $deviceId)
        ->and(value: $share->token)->toBe(expected: $token);
});
