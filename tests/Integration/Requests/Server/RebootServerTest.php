<?php

declare(strict_types=1);

use ThingsTelemetry\Traccar\Requests\Server\RebootServer;

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new RebootServer();

    expect(value: $request->resolveEndpoint())->toBe(expected: '/server/reboot')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'POST');
});
