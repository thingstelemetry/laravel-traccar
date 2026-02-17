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

it(description: 'can link a user to a device', closure: function () {
    MockClient::global([
        LinkPermission::class => MockResponse::make('', 204),
    ]);

    $permission = new PermissionData(userId: 1, deviceId: 5);
    $result = Permission::link($permission);

    expect($result)
        ->toBeInstanceOf(StatusData::class)
        ->and($result->status)->toEqual(Status::SUCCESS);
});

it(description: 'can unlink a user from a device', closure: function () {
    MockClient::global([
        UnlinkPermission::class => MockResponse::make('', 204),
    ]);

    $permission = new PermissionData(userId: 1, deviceId: 5);
    $result = Permission::unlink($permission);

    expect($result)
        ->toBeInstanceOf(StatusData::class)
        ->and($result->status)->toEqual(Status::SUCCESS);
});

it(description: 'can link multiple permissions in bulk', closure: function () {
    MockClient::global([
        LinkPermissionsBulk::class => MockResponse::make('', 204),
    ]);

    $permissions = [
        new PermissionData(userId: 1, deviceId: 5),
        new PermissionData(userId: 1, deviceId: 6),
        new PermissionData(userId: 2, groupId: 3),
    ];

    $result = Permission::linkBulk($permissions);

    expect($result)
        ->toBeInstanceOf(StatusData::class)
        ->and($result->status)->toEqual(Status::SUCCESS);
});

it(description: 'can unlink multiple permissions in bulk', closure: function () {
    MockClient::global([
        UnlinkPermissionsBulk::class => MockResponse::make('', 204),
    ]);

    $permissions = [
        new PermissionData(userId: 1, deviceId: 5),
        new PermissionData(userId: 1, deviceId: 6),
    ];

    $result = Permission::unlinkBulk($permissions);

    expect($result)
        ->toBeInstanceOf(StatusData::class)
        ->and($result->status)->toEqual(Status::SUCCESS);
});

it(description: 'validates permission has exactly 2 properties', closure: function () {
    $permission = new PermissionData(userId: 1);
    $permission->validate();
})->throws(exception: InvalidArgumentException::class, exceptionMessage: 'Permission must have exactly 2 properties set, 1 given.');

it(description: 'validates permission has exactly 2 properties - too many', closure: function () {
    $permission = new PermissionData(userId: 1, deviceId: 2, groupId: 3);
    $permission->validate();
})->throws(exception: InvalidArgumentException::class, exceptionMessage: 'Permission must have exactly 2 properties set, 3 given.');

it(description: 'can create permission data from array', closure: function () {
    $data = [
        'userId'   => 5,
        'deviceId' => 10,
    ];

    $permission = PermissionData::fromArray($data);

    expect($permission)
        ->toBeInstanceOf(PermissionData::class)
        ->and($permission->userId)->toEqual(5)
        ->and($permission->deviceId)->toEqual(10)
        ->and($permission->groupId)->toBeNull();
});

it(description: 'can convert permission data to array', closure: function () {
    $permission = new PermissionData(userId: 5, geofenceId: 3);

    $array = $permission->toArray();

    expect($array)
        ->toBeArray()
        ->toHaveCount(2)
        ->and($array['userId'])->toEqual(5)
        ->and($array['geofenceId'])->toEqual(3);
});

it(description: 'excludes null values from toArray', closure: function () {
    $permission = new PermissionData(deviceId: 10, commandId: 8);

    $array = $permission->toArray();

    expect($array)
        ->toBeArray()
        ->toHaveCount(2)
        ->and($array)->not->toHaveKey('userId')
        ->and($array)->not->toHaveKey('groupId');
});

it(description: 'can create various permission types', closure: function () {
    MockClient::global([
        LinkPermission::class => MockResponse::make('', 204),
    ]);

    $userToDevice = new PermissionData(userId: 1, deviceId: 10);
    $userToGroup = new PermissionData(userId: 1, groupId: 5);
    $userToGeofence = new PermissionData(userId: 1, geofenceId: 3);
    $userToNotification = new PermissionData(userId: 1, notificationId: 7);
    $deviceToGeofence = new PermissionData(deviceId: 10, geofenceId: 3);
    $groupToCommand = new PermissionData(groupId: 5, commandId: 2);
    $userToManagedUser = new PermissionData(userId: 1, managedUserId: 8);

    expect(Permission::link($userToDevice)->status)->toEqual(Status::SUCCESS)
        ->and(Permission::link($userToGroup)->status)->toEqual(Status::SUCCESS)
        ->and(Permission::link($userToGeofence)->status)->toEqual(Status::SUCCESS)
        ->and(Permission::link($userToNotification)->status)->toEqual(Status::SUCCESS)
        ->and(Permission::link($deviceToGeofence)->status)->toEqual(Status::SUCCESS)
        ->and(Permission::link($groupToCommand)->status)->toEqual(Status::SUCCESS)
        ->and(Permission::link($userToManagedUser)->status)->toEqual(Status::SUCCESS);
});
