<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Dto\PermissionData;
use ThingsTelemetry\Traccar\Requests\Permission\UnlinkPermissionsBulk;

test(description: 'it can unlink permissions in bulk', closure: function () {
    $permissions = [
        new PermissionData(userId: 1, deviceId: 5),
        new PermissionData(userId: 1, deviceId: 6),
    ];

    $mockClient = new MockClient(mockData: [
        UnlinkPermissionsBulk::class => MockResponse::make(body: '', status: 204),
    ]);

    $request = new UnlinkPermissionsBulk(permissions: $permissions);
    $response = connector()->send(request: $request, mockClient: $mockClient);

    expect(value: $response->dto())
        ->toBeInstanceOf(class: StatusData::class)
        ->and(value: $response->dto()->status)->toBe(Status::SUCCESS);
});
