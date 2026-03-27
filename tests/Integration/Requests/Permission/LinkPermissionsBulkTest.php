<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Dto\PermissionData;
use ThingsTelemetry\Traccar\Requests\Permission\LinkPermissionsBulk;

test(description: 'it can link permissions in bulk', closure: function () {
    $permissions = [
        new PermissionData(userId: 1, deviceId: 5),
        new PermissionData(userId: 1, deviceId: 6),
    ];

    $mockClient = new MockClient(mockData: [
        LinkPermissionsBulk::class => MockResponse::make(body: '', status: 204),
    ]);

    $request = new LinkPermissionsBulk(permissions: $permissions);
    $response = connector()->send(request: $request, mockClient: $mockClient);

    expect(value: $response->dto())
        ->toBeInstanceOf(class: StatusData::class)
        ->and(value: $response->dto()->status)->toBe(Status::SUCCESS);
});
