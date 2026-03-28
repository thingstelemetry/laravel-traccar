<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Requests\Server\GetServerStatistics;

test(description: 'it resolves the correct endpoint', closure: function () {
    $from = CarbonImmutable::parse(time: '2019-08-24T00:00:00Z');
    $to = CarbonImmutable::parse(time: '2019-08-25T00:00:00Z');

    $request = new GetServerStatistics(from: $from, to: $to);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/statistics')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'GET');
});

test(description: 'it sends the correct query parameters', closure: function () {
    $from = CarbonImmutable::parse(time: '2019-08-24T00:00:00Z');
    $to = CarbonImmutable::parse(time: '2019-08-25T00:00:00Z');

    $request = new GetServerStatistics(from: $from, to: $to);

    expect(value: $request->query()->get(key: 'from'))->toBe(expected: $from->toIso8601String())
        ->and(value: $request->query()->get(key: 'to'))->toBe(expected: $to->toIso8601String());
});
