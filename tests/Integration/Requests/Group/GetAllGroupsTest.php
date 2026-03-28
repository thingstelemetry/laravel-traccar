<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\Group;

use ThingsTelemetry\Traccar\Requests\Group\GetAllGroups;

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new GetAllGroups();

    expect(value: $request->resolveEndpoint())->toBe(expected: '/groups')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'GET');
});
