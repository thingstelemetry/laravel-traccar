<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\Group;

use ThingsTelemetry\Traccar\Requests\Group\GetGroup;

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new GetGroup(id: 1);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/groups/1')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'GET');
});
