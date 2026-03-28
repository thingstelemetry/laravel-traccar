<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Requests\Share\ShareGroup;

test(description: 'it resolves the correct endpoint', closure: function () {
    $expiration = CarbonImmutable::parse(time: '2030-12-31T23:59:59Z');
    $request = new ShareGroup(groupId: 6, expiration: $expiration);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/share/group')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'POST');
});

test(description: 'it sends the correct body parameters', closure: function () {
    $expiration = CarbonImmutable::parse(time: '2030-12-31T23:59:59Z');
    $request = new ShareGroup(groupId: 6, expiration: $expiration);

    expect(value: $request->body()->all())->toBe(expected: [
        'groupId'    => 6,
        'expiration' => $expiration->toIso8601String(),
    ]);
});
