<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\Device;

use ThingsTelemetry\Traccar\Requests\Device\DeleteDevice;

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new DeleteDevice(id: 6);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/devices/6')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'DELETE');
});
