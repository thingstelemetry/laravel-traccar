<?php

declare(strict_types=1);

use ThingsTelemetry\Traccar\Requests\Position\DeletePosition;

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new DeletePosition(id: 123);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/positions/123')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'DELETE');
});
