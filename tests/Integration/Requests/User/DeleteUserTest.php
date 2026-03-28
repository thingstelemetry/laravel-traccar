<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\User;

use ThingsTelemetry\Traccar\Requests\User\DeleteUser;

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new DeleteUser(id: 6);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/users/6')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'DELETE');
});
