<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\User;

use ThingsTelemetry\Traccar\Requests\User\GetAllUsers;

beforeEach(closure: function () {
    $this->usersData = [
        [
            'id'               => 1,
            'name'             => 'Alice',
            'email'            => 'alice@example.com',
            'phone'            => null,
            'readonly'         => false,
            'administrator'    => false,
            'map'              => 'osm',
            'latitude'         => 0,
            'longitude'        => 0,
            'zoom'             => 10,
            'password'         => null,
            'coordinateFormat' => 'dd',
            'disabled'         => false,
            'expirationTime'   => null,
            'deviceLimit'      => 0,
            'userLimit'        => 0,
            'deviceReadonly'   => false,
            'limitCommands'    => false,
            'fixedEmail'       => false,
            'poiLayer'         => null,
            'attributes'       => [],
        ],
        [
            'id'               => 2,
            'name'             => 'Bob',
            'email'            => 'bob@example.com',
            'phone'            => null,
            'readonly'         => false,
            'administrator'    => false,
            'map'              => 'osm',
            'latitude'         => 0,
            'longitude'        => 0,
            'zoom'             => 10,
            'password'         => null,
            'coordinateFormat' => 'dd',
            'disabled'         => false,
            'expirationTime'   => null,
            'deviceLimit'      => 0,
            'userLimit'        => 0,
            'deviceReadonly'   => false,
            'limitCommands'    => false,
            'fixedEmail'       => false,
            'poiLayer'         => null,
            'attributes'       => [],
        ],
    ];
});

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new GetAllUsers();

    expect(value: $request->resolveEndpoint())->toBe(expected: '/users')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'GET');
});
