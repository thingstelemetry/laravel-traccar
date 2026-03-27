<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Dto\PermissionData;
use ThingsTelemetry\Traccar\Facades\Permission;
use ThingsTelemetry\Traccar\Requests\Permission\LinkPermission;
use ThingsTelemetry\Traccar\Requests\Permission\UnlinkPermission;
use ThingsTelemetry\Traccar\Requests\Permission\LinkPermissionsBulk;
use ThingsTelemetry\Traccar\Requests\Permission\UnlinkPermissionsBulk;

test(description: 'can link a user to a device', closure: function () {
    MockClient::global([
        LinkPermission::class => MockResponse::make('', 204),
    ]);

    $permission = new PermissionData(userId: 1, deviceId: 5);
    $result = Permission::link($permission);

    expect($result)
        ->toBeInstanceOf(StatusData::class)
        ->and($result->status)->toEqual(Status::SUCCESS);
});

test(description: 'can unlink a user from a device', closure: function () {
    MockClient::global([
        UnlinkPermission::class => MockResponse::make('', 204),
    ]);

    $permission = new PermissionData(userId: 1, deviceId: 5);
    $result = Permission::unlink($permission);

    expect($result)
        ->toBeInstanceOf(StatusData::class)
        ->and($result->status)->toEqual(Status::SUCCESS);
});

test(description: 'can link multiple permissions in bulk', closure: function () {
    MockClient::global([
        LinkPermissionsBulk::class => MockResponse::make('', 204),
    ]);

    $permissions = [
        new PermissionData(userId: 1, deviceId: 5),
    ];

    $result = Permission::linkBulk($permissions);

    expect($result)
        ->toBeInstanceOf(StatusData::class)
        ->and($result->status)->toEqual(Status::SUCCESS);
});

test(description: 'can unlink multiple permissions in bulk', closure: function () {
    MockClient::global([
        UnlinkPermissionsBulk::class => MockResponse::make('', 204),
    ]);

    $permissions = [
        new PermissionData(userId: 1, deviceId: 5),
    ];

    $result = Permission::unlinkBulk($permissions);

    expect($result)
        ->toBeInstanceOf(StatusData::class)
        ->and($result->status)->toEqual(Status::SUCCESS);
});
