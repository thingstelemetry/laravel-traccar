<?php

declare(strict_types=1);

use ThingsTelemetry\Traccar\Requests\Server\GetServerInformation;

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new GetServerInformation();

    expect(value: $request->resolveEndpoint())->toBe(expected: '/server')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'GET');
});
