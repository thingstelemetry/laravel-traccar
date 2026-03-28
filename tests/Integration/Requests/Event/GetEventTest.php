<?php

declare(strict_types=1);

use ThingsTelemetry\Traccar\Requests\Event\GetEvent;

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new GetEvent(id: 1);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/events/1')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'GET');
});
