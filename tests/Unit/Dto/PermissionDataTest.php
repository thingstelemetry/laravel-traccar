<?php

declare(strict_types=1);

namespace Tests\Unit\Dto;

use InvalidArgumentException;
use ThingsTelemetry\Traccar\Dto\PermissionData;

test(description: 'validates permission has exactly 2 properties', closure: function () {
    $permission = new PermissionData(userId: 1);
    $permission->validate();
})->throws(exception: InvalidArgumentException::class, exceptionMessage: 'Permission must have exactly 2 properties set, 1 given.');

test(description: 'validates permission has exactly 2 properties - too many', closure: function () {
    $permission = new PermissionData(userId: 1, deviceId: 2, groupId: 3);
    $permission->validate();
})->throws(exception: InvalidArgumentException::class, exceptionMessage: 'Permission must have exactly 2 properties set, 3 given.');

test(description: 'can create permission data from array', closure: function () {
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

test(description: 'can convert permission data to array', closure: function () {
    $permission = new PermissionData(userId: 5, geofenceId: 3);

    $array = $permission->toArray();

    expect($array)
        ->toBeArray()
        ->toHaveCount(2)
        ->and($array['userId'])->toEqual(5)
        ->and($array['geofenceId'])->toEqual(3);
});

test(description: 'excludes null values from toArray', closure: function () {
    $permission = new PermissionData(deviceId: 10, commandId: 8);

    $array = $permission->toArray();

    expect($array)
        ->toBeArray()
        ->toHaveCount(2)
        ->and($array)->not->toHaveKey('userId')
        ->and($array)->not->toHaveKey('groupId');
});
