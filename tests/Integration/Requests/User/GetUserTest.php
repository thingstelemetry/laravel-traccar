<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\User;

use ThingsTelemetry\Traccar\Requests\User\GetUser;

beforeEach(closure: function () {
    $this->userData = [
        'id'               => 6,
        'name'             => 'Jane Doe',
        'email'            => 'jane@example.com',
        'phone'            => '+15551234567',
        'readonly'         => false,
        'administrator'    => false,
        'map'              => 'osm',
        'latitude'         => 0.0,
        'longitude'        => 0.0,
        'zoom'             => 0,
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
    ];
});

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new GetUser(id: 6);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/users/6')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'GET');
});
