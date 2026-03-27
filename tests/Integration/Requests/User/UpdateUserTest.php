<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\User;

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\UserData;
use ThingsTelemetry\Traccar\TraccarConnector;
use ThingsTelemetry\Traccar\Enums\CoordinateFormat;
use ThingsTelemetry\Traccar\Requests\User\UpdateUser;

beforeEach(closure: function () {
    $this->connector = new TraccarConnector(
        baseUrl: 'https://demo.traccar.org/api',
        apiKey: 'test-api-key'
    );

    $this->userData = [
        'id'               => 6,
        'name'             => 'Jane Doe - Updated',
        'email'            => 'jane@example.com',
        'phone'            => '+15551234567',
        'readonly'         => false,
        'administrator'    => false,
        'map'              => 'osm',
        'latitude'         => 0.0,
        'longitude'        => 0.0,
        'zoom'             => 0,
        'password'         => null,
        'coordinateFormat' => 'ddm',
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
    $request = new UpdateUser(data: $data);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/users/6')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'PUT');
});

test(description: 'it sends the correct body', closure: function () {
    $data = UserData::fromArray(data: $this->userData);
    $request = new UpdateUser(data: $data);

    expect(value: $request->body()->all())->toEqual(expected: $data->toArray());
});

test(description: 'it creates a UserData DTO from response via createDtoFromResponse', closure: function () {
    $mockClient = new MockClient(mockData: [
        UpdateUser::class => MockResponse::make(body: $this->userData, status: 200),
    ]);

    $data = UserData::fromArray(data: $this->userData);
    $request = new UpdateUser(data: $data);
    $response = $this->connector->send(request: $request, mockClient: $mockClient);

    $user = $response->dtoOrFail();

    expect(value: $user)->toBeInstanceOf(class: UserData::class)
        ->and(value: $user->id)->toBe(expected: 6)
        ->and(value: $user->name)->toBe(expected: 'Jane Doe - Updated')
        ->and(value: $user->coordinateFormat)->toBe(expected: CoordinateFormat::DDM);
});
