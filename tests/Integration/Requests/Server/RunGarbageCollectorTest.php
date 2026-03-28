<?php

declare(strict_types=1);

use ThingsTelemetry\Traccar\Requests\Server\RunGarbageCollector;

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new RunGarbageCollector();

    expect(value: $request->resolveEndpoint())->toBe(expected: '/server/gc')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'GET');
});
