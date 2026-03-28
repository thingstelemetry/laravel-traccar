<?php

declare(strict_types=1);

use ThingsTelemetry\Traccar\Dto\PermissionData;
use ThingsTelemetry\Traccar\Requests\Permission\LinkPermissionsBulk;

test(description: 'it resolves the correct endpoint', closure: function () {
    $permissions = [new PermissionData(userId: 1, deviceId: 5)];
    $request = new LinkPermissionsBulk(permissions: $permissions);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/permissions')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'POST');
});

test(description: 'it sends the correct body', closure: function () {
    $permissions = [
        new PermissionData(userId: 1, deviceId: 5),
        new PermissionData(userId: 1, deviceId: 6),
    ];
    $request = new LinkPermissionsBulk(permissions: $permissions);

    expect(value: $request->body()->all())->toBe(expected: [
        ['userId' => 1, 'deviceId' => 5],
        ['userId' => 1, 'deviceId' => 6],
    ]);
});
