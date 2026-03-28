<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\Session;

use ThingsTelemetry\Traccar\Requests\Session\GetSessionById;

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new GetSessionById(userId: 1);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/session/1')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'GET');
});
