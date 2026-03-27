<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\User;

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\UserData;
use ThingsTelemetry\Traccar\TraccarConnector;
use ThingsTelemetry\Traccar\Requests\User\GetUser;
use Saloon\Exceptions\Request\Statuses\NotFoundException;

beforeEach(closure: function () {
    $this->connector = new TraccarConnector(
        baseUrl: 'https://demo.traccar.org/api',
        apiKey: 'test-api-key'
    );

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

test(description: 'it creates a UserData DTO from response via createDtoFromResponse', closure: function () {
    $mockClient = new MockClient(mockData: [
        GetUser::class => MockResponse::make(body: $this->userData, status: 200),
    ]);

    $request = new GetUser(id: 6);
    $response = $this->connector->send(request: $request, mockClient: $mockClient);

    $user = $response->dtoOrFail();

    expect(value: $user)->toBeInstanceOf(class: UserData::class)
        ->and(value: $user->id)->toBe(expected: 6)
        ->and(value: $user->email)->toBe(expected: 'jane@example.com');
});

test(description: 'it throws NotFoundException when user is not found via createDtoFromResponse', closure: function () {
    $mockClient = new MockClient(mockData: [
        GetUser::class => MockResponse::make(body: [], status: 200),
    ]);

    $request = new GetUser(id: 999);

    expect(value: fn () => $this->connector->send(request: $request, mockClient: $mockClient)->dtoOrFail())
        ->toThrow(exception: NotFoundException::class, exceptionMessage: 'Traccar user was not found. Check the user ID and try again.');
});
