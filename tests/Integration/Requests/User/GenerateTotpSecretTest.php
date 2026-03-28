<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\User;

use ThingsTelemetry\Traccar\Requests\User\GenerateTotpSecret;

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new GenerateTotpSecret();

    expect(value: $request->resolveEndpoint())->toBe(expected: '/users/totp')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'POST');
});
