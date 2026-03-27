<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Dto\PermissionData;
use ThingsTelemetry\Traccar\Requests\Permission\UnlinkPermission;

test(description: 'it can unlink a permission', closure: function () {
    $data = new PermissionData(userId: 1, deviceId: 6);

    $mockClient = new MockClient(mockData: [
        UnlinkPermission::class => MockResponse::make(body: '', status: 204),
    ]);

    $request = new UnlinkPermission(data: $data);
    $response = connector()->send(request: $request, mockClient: $mockClient);

    expect(value: $response->dto())
        ->toBeInstanceOf(class: StatusData::class)
        ->and(value: $response->dto()->status)->toBe(Status::SUCCESS);
});
