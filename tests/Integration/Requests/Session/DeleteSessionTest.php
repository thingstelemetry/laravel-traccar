<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\Session;

use ThingsTelemetry\Traccar\Requests\Session\DeleteSession;

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new DeleteSession();

    expect(value: $request->resolveEndpoint())->toBe(expected: '/session')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'DELETE');
});
