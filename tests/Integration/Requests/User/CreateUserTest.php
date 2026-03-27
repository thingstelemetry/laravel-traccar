<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\User;

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\UserData;
use ThingsTelemetry\Traccar\TraccarConnector;
use ThingsTelemetry\Traccar\Requests\User\CreateUser;
use ThingsTelemetry\Traccar\Enums\Map;
use ThingsTelemetry\Traccar\Enums\CoordinateFormat;
use ThingsTelemetry\Traccar\Dto\UserAttributesData;

beforeEach(closure: function () {
    $this->connector = new TraccarConnector(
        baseUrl: 'https://demo.traccar.org/api',
        apiKey: 'test-api-key'
    );

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

    expect(value: $request->resolveEndpoint())->toBe(expected: '/users');
});

test(description: 'it creates a UserData DTO from response via createDtoFromResponse', closure: function () {
    $mockClient = new MockClient(mockData: [
        CreateUser::class => MockResponse::make(body: $this->userData, status: 201),
    ]);

    $data = UserData::fromArray(data: $this->userData);
    $request = new CreateUser(data: $data);
    $response = $this->connector->send(request: $request, mockClient: $mockClient);

    $user = $response->dtoOrFail();

    expect(value: $user)->toBeInstanceOf(class: UserData::class)
        ->and(value: $user->id)->toBe(expected: 8)
        ->and(value: $user->name)->toBe(expected: 'Alice')
        ->and(value: $user->email)->toBe(expected: 'alice@example.com')
        ->and(value: $user->map)->toBe(expected: Map::OSM)
        ->and(value: $user->coordinateFormat)->toBe(expected: CoordinateFormat::DD);
});

test(description: 'it sends the correct body', closure: function () {
    $data = UserData::fromArray(data: $this->userData);
    $request = new CreateUser(data: $data);

    expect(value: $request->body()->all())->toEqual(expected: $data->toArray());
});
