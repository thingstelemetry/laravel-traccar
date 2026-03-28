<?php

declare(strict_types=1);

use Saloon\Enums\Method;
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

describe(description: 'link', tests: function () {
    test(description: 'request sends the correct body', closure: function () {
        $permission = new PermissionData(userId: 1, deviceId: 5);
        $request = new LinkPermission(data: $permission);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/permissions')
            ->and(value: $request->getMethod())->toBe(expected: Method::POST)
            ->and(value: $request->body()->all())->toBe(expected: [
                'userId'   => 1,
                'deviceId' => 5,
            ]);
    });

    test(description: 'links a user to a device', closure: function () {
        MockClient::global(mockData: [
            LinkPermission::class => MockResponse::make(body: '', status: 204),
        ]);

        $permission = new PermissionData(userId: 1, deviceId: 5);
        $result = Permission::link($permission);

        expect(value: $result)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
    });
});

describe(description: 'unlink', tests: function () {
    test(description: 'request sends the correct body', closure: function () {
        $permission = new PermissionData(userId: 1, deviceId: 5);
        $request = new UnlinkPermission(data: $permission);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/permissions')
            ->and(value: $request->getMethod())->toBe(expected: Method::DELETE)
            ->and(value: $request->body()->all())->toBe(expected: [
                'userId'   => 1,
                'deviceId' => 5,
            ]);
    });

    test(description: 'unlinks a user from a device', closure: function () {
        MockClient::global(mockData: [
            UnlinkPermission::class => MockResponse::make(body: '', status: 204),
        ]);

        $permission = new PermissionData(userId: 1, deviceId: 5);
        $result = Permission::unlink($permission);

        expect(value: $result)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
    });
});

describe(description: 'link bulk', tests: function () {
    test(description: 'request sends the correct body', closure: function () {
        $permissions = [
            new PermissionData(userId: 1, deviceId: 5),
            new PermissionData(userId: 1, deviceId: 6),
        ];
        $request = new LinkPermissionsBulk(permissions: $permissions);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/permissions/bulk')
            ->and(value: $request->getMethod())->toBe(expected: Method::POST)
            ->and(value: $request->body()->all())->toBe(expected: [
                ['userId' => 1, 'deviceId' => 5],
                ['userId' => 1, 'deviceId' => 6],
            ]);
    });

    test(description: 'links permissions in bulk', closure: function () {
        MockClient::global(mockData: [
            LinkPermissionsBulk::class => MockResponse::make(body: '', status: 204),
        ]);

        $permissions = [
            new PermissionData(userId: 1, deviceId: 5),
        ];

        $result = Permission::linkBulk($permissions);

        expect(value: $result)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
    });
});

describe(description: 'unlink bulk', tests: function () {
    test(description: 'request sends the correct body', closure: function () {
        $permissions = [
            new PermissionData(userId: 1, deviceId: 5),
            new PermissionData(userId: 1, deviceId: 6),
        ];
        $request = new UnlinkPermissionsBulk(permissions: $permissions);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/permissions/bulk')
            ->and(value: $request->getMethod())->toBe(expected: Method::DELETE)
            ->and(value: $request->body()->all())->toBe(expected: [
                ['userId' => 1, 'deviceId' => 5],
                ['userId' => 1, 'deviceId' => 6],
            ]);
    });

    test(description: 'unlinks permissions in bulk', closure: function () {
        MockClient::global(mockData: [
            UnlinkPermissionsBulk::class => MockResponse::make(body: '', status: 204),
        ]);

        $permissions = [
            new PermissionData(userId: 1, deviceId: 5),
        ];

        $result = Permission::unlinkBulk($permissions);

        expect(value: $result)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
    });
});
