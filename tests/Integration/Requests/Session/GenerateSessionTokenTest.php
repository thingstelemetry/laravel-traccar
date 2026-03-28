<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\Session;

use ThingsTelemetry\Traccar\Requests\Session\GenerateSessionToken;

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new GenerateSessionToken();

    expect(value: $request->resolveEndpoint())->toBe(expected: '/session/token')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'POST');
});
