<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Requests\Share\ShareDevice;

test(description: 'it resolves the correct endpoint', closure: function () {
    $expiration = CarbonImmutable::parse(time: '2026-12-01T12:00:00Z');
    $request = new ShareDevice(deviceId: 6, expiration: $expiration);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/share/device')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'POST');
});

test(description: 'it sends the correct body parameters', closure: function () {
    $expiration = CarbonImmutable::parse(time: '2026-12-01T12:00:00Z');
    $request = new ShareDevice(deviceId: 6, expiration: $expiration);

    expect(value: $request->body()->all())->toBe(expected: [
        'deviceId'   => 6,
        'expiration' => $expiration->toIso8601String(),
    ]);
});
