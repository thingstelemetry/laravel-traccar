<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\User;

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\UserData;
use ThingsTelemetry\Traccar\TraccarConnector;
use ThingsTelemetry\Traccar\Requests\User\GetAllUsers;

beforeEach(closure: function () {
    $this->connector = new TraccarConnector(
        baseUrl: 'https://demo.traccar.org/api',
        apiKey: 'test-api-key'
    );

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

    expect(value: $request->resolveEndpoint())->toBe(expected: '/users');
});

test(description: 'it creates an array of UserData DTOs from response via createDtoFromResponse', closure: function () {
    $mockClient = new MockClient(mockData: [
        GetAllUsers::class => MockResponse::make(body: $this->usersData, status: 200),
    ]);

    $request = new GetAllUsers();
    $response = $this->connector->send(request: $request, mockClient: $mockClient);

    $users = $response->dtoOrFail();

    expect(value: $users)->toBeArray()
        ->and(value: count(value: $users))->toBe(expected: 2)
        ->and(value: $users[0])->toBeInstanceOf(class: UserData::class)
        ->and(value: $users[0]->id)->toBe(expected: 1)
        ->and(value: $users[1]->id)->toBe(expected: 2);
});
