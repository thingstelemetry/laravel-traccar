<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Requests\Position\DeleteDevicePositions;

test(description: 'it resolves the correct endpoint', closure: function () {
    $from = CarbonImmutable::parse(time: '2026-11-22T18:30:00Z');
    $to = CarbonImmutable::parse(time: '2026-11-23T18:30:00Z');

    $request = new DeleteDevicePositions(deviceId: 6, from: $from, to: $to);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/positions')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'DELETE');
});

test(description: 'it sends the correct query parameters', closure: function () {
    $from = CarbonImmutable::parse(time: '2026-11-22T18:30:00Z');
    $to = CarbonImmutable::parse(time: '2026-11-23T18:30:00Z');

    $request = new DeleteDevicePositions(deviceId: 6, from: $from, to: $to);

    expect(value: $request->query()->get(key: 'deviceId'))->toBe(expected: 6)
        ->and(value: $request->query()->get(key: 'from'))->toBe(expected: $from->toIso8601String())
        ->and(value: $request->query()->get(key: 'to'))->toBe(expected: $to->toIso8601String());
});
