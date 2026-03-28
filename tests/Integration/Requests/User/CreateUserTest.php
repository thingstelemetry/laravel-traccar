<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\User;

use ThingsTelemetry\Traccar\Dto\UserData;
use ThingsTelemetry\Traccar\Requests\User\CreateUser;

beforeEach(closure: function () {
    $this->userData = [
        'id'               => 8,
        'name'             => 'Alice',
        'email'            => 'alice@example.com',
        'phone'            => '+15557654321',
        'readonly'         => false,
        'administrator'    => false,
        'map'              => 'osm',
        'latitude'         => 0.0,
        'longitude'        => 0.0,
        'zoom'             => 0,
        'password'         => 'top-secret',
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
    $data = UserData::fromArray(data: $this->userData);
    $request = new CreateUser(data: $data);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/users')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'POST');
});

test(description: 'it sends the correct body', closure: function () {
    $data = UserData::fromArray(data: $this->userData);
    $request = new CreateUser(data: $data);

    expect(value: $request->body()->all())->toBe(expected: $data->toArray());
});
