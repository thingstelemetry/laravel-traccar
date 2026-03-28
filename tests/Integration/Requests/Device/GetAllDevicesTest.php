<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\Device;

use ThingsTelemetry\Traccar\Requests\Device\GetAllDevices;

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new GetAllDevices();

    expect(value: $request->resolveEndpoint())->toBe(expected: '/devices')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'GET');
});
