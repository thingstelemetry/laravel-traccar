<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use TrackTelemetry\Traccar\Enums\Map;
use TrackTelemetry\Traccar\Dto\UserData;
use TrackTelemetry\Traccar\Enums\Status;
use TrackTelemetry\Traccar\Facades\User;
use TrackTelemetry\Traccar\Dto\StatusData;
use TrackTelemetry\Traccar\Requests\GetUser;
use TrackTelemetry\Traccar\Requests\CreateUser;
use TrackTelemetry\Traccar\Requests\DeleteUser;
use TrackTelemetry\Traccar\Requests\UpdateUser;
use TrackTelemetry\Traccar\Requests\GetAllUsers;
use TrackTelemetry\Traccar\Dto\UserAttributesData;
use TrackTelemetry\Traccar\Enums\CoordinateFormat;
use Saloon\Exceptions\Request\Statuses\NotFoundException;

beforeEach(function () {
    $this->users = [
        [
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
        ],
        [
            'id'               => 7,
            'name'             => 'John Smith',
            'email'            => 'john@example.com',
            'phone'            => null,
            'readonly'         => true,
            'administrator'    => false,
            'map'              => 'osm',
            'latitude'         => 0.0,
            'longitude'        => 0.0,
            'zoom'             => 0,
            'password'         => null,
            'coordinateFormat' => 'ddm',
            'disabled'         => false,
            'expirationTime'   => null,
            'deviceLimit'      => 10,
            'userLimit'        => 1,
            'deviceReadonly'   => false,
            'limitCommands'    => true,
            'fixedEmail'       => true,
            'poiLayer'         => null,
            'attributes'       => [],
        ],
    ];
});

it(description: 'can get all users', closure: function () {
    MockClient::global([
        GetAllUsers::class => MockResponse::make($this->users),
    ]);

    $response = User::all();

    expect($response)
        ->toBeArray()
        ->toHaveCount(2);

    $first = $response[0];
    expect($first)
        ->toBeInstanceOf(UserData::class)
        ->and($first->map)->toEqual(Map::OSM)
        ->and($first->coordinateFormat)->toEqual(CoordinateFormat::DD);
});

it(description: 'can get a user by id', closure: function () {
    MockClient::global([
        GetUser::class => MockResponse::make($this->users[0]),
    ]);

    $user = User::get(6);

    expect($user)
        ->toBeInstanceOf(UserData::class)
        ->and($user->id)->toEqual(6)
        ->and($user->email)->toEqual('jane@example.com');
});

it(description: 'can create a user', closure: function () {
    $created = [
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
        'password'         => null,
        'coordinateFormat' => 'dd',
        'disabled'         => false,
        'deviceLimit'      => 0,
        'userLimit'        => 0,
        'deviceReadonly'   => false,
        'limitCommands'    => false,
        'fixedEmail'       => false,
        'poiLayer'         => null,
        'attributes'       => [],
    ];

    MockClient::global([
        CreateUser::class => MockResponse::make($created),
    ]);

    $attributes = new UserAttributesData(language: 'en');

    $requestData = new UserData(
        id: 0,
        name: 'Alice',
        email: 'alice@example.com',
        phone: '+15557654321',
        readonly: false,
        administrator: false,
        map: Map::OSM,
        latitude: 0.0,
        longitude: 0.0,
        zoom: 0,
        password: 'top-secret',
        coordinateFormat: CoordinateFormat::DD,
        disabled: false,
        expirationTime: null,
        deviceLimit: 0,
        userLimit: 0,
        deviceReadonly: false,
        limitCommands: false,
        fixedEmail: false,
        poiLayer: null,
        attributes: $attributes,
    );

    $response = User::create($requestData);

    expect($response)
        ->toBeInstanceOf(UserData::class)
        ->and($response->id)->toEqual(8)
        ->and($response->map)->toEqual(Map::OSM);
});

it(description: 'can update a user', closure: function () {
    $updated = $this->users[0];
    $updated['name'] = 'Jane Doe - Updated';
    $updated['coordinateFormat'] = 'ddm';

    MockClient::global([
        UpdateUser::class => MockResponse::make($updated),
    ]);

    $data = UserData::fromArray($updated);

    $response = User::update($data);

    expect($response)
        ->toBeInstanceOf(UserData::class)
        ->and($response->name)->toEqual('Jane Doe - Updated')
        ->and($response->coordinateFormat)->toEqual(CoordinateFormat::DDM);
});

it(description: 'can delete a user', closure: function () {
    MockClient::global([
        DeleteUser::class => MockResponse::make(body: '', status: 204),
    ]);

    $result = User::delete(id: 6);

    expect($result)
        ->toBeInstanceOf(StatusData::class)
        ->and($result->status)->toEqual(Status::SUCCESS);
});

it(description: 'can retrieve a user by id', closure: function () {
    $payload = [
        'id'               => 42,
        'name'             => 'Jane Doe',
        'email'            => 'jane@example.com',
        'phone'            => '+123456789',
        'readonly'         => false,
        'administrator'    => true,
        'map'              => 'osm',
        'latitude'         => -1.286389,
        'longitude'        => 36.817223,
        'zoom'             => 12,
        'password'         => null,
        'coordinateFormat' => 'dd',
        'disabled'         => false,
        'expirationTime'   => '2019-08-24T14:15:22Z',
        'deviceLimit'      => 100,
        'userLimit'        => 10,
        'deviceReadonly'   => false,
        'limitCommands'    => true,
        'fixedEmail'       => true,
        'poiLayer'         => 'poi-layer',
        'attributes'       => ['ui.disableGroups' => true],
    ];

    MockClient::global(mockData: [
        GetUser::class => MockResponse::make($payload),
    ]);

    $user = User::get(42);

    expect(value: $user)
        ->toBeInstanceOf(class: UserData::class)
        ->and(value: $user->map)->toEqual(expected: Map::OSM)
        ->and(value: $user->coordinateFormat)->toEqual(expected: CoordinateFormat::DD)
        ->and(value: $user->expirationTime)->toBeInstanceOf(class: CarbonImmutable::class)
        ->and(value: $user->expirationTime->toIso8601String())->toEqual(expected: '2019-08-24T14:15:22+00:00')
        ->and(value: $user->attributes->toArray())
        ->toHaveKey(key: 'ui.disableGroups', value: true);
});

it(description: 'throws JsonException on invalid JSON response', closure: function () {
    MockClient::global(mockData: [
        GetUser::class => MockResponse::make('not-json', 200, ['Content-Type' => 'application/json']),
    ]);

    expect(value: fn () => User::get(1))->toThrow(exception: JsonException::class);
});

it(description: 'can retrieve all users', closure: function () {
    $payload = [
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

    MockClient::global(mockData: [
        \TrackTelemetry\Traccar\Requests\GetAllUsers::class => MockResponse::make($payload),
    ]);

    $users = User::all();

    expect($users)
        ->toBeArray()
        ->and(count($users))->toBe(2)
        ->and($users[0])->toBeInstanceOf(UserData::class);
});

it(description: 'throws NotFoundException when user is missing', closure: function () {
    MockClient::global(mockData: [
        GetUser::class => MockResponse::make([], 200),
    ]);

    expect(value: fn () => User::get(999))->toThrow(exception: NotFoundException::class);
});
