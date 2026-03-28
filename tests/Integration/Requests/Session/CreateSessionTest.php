<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\Session;

use ThingsTelemetry\Traccar\Requests\Session\CreateSession;

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new CreateSession(email: 'jane@example.com', password: 'secret123');

    expect(value: $request->resolveEndpoint())->toBe(expected: '/session')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'POST');
});

test(description: 'it sends the correct body', closure: function () {
    $request = new CreateSession(email: 'jane@example.com', password: 'secret123');

    expect(value: $request->body()->all())->toBe(expected: [
        'email'    => 'jane@example.com',
        'password' => 'secret123',
    ]);
});
