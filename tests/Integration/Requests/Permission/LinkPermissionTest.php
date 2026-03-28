<?php

declare(strict_types=1);

use ThingsTelemetry\Traccar\Dto\PermissionData;
use ThingsTelemetry\Traccar\Requests\Permission\LinkPermission;

test(description: 'it resolves the correct endpoint', closure: function () {
    $data = new PermissionData(userId: 1, deviceId: 6);
    $request = new LinkPermission(data: $data);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/permissions')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'POST');
});

test(description: 'it sends the correct body', closure: function () {
    $data = new PermissionData(userId: 1, deviceId: 6);
    $request = new LinkPermission(data: $data);

    expect(value: $request->body()->all())->toBe(expected: [
        'userId'   => 1,
        'deviceId' => 6,
    ]);
});
