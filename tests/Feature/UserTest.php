<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\UserData;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Facades\User;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Requests\User\GetUser;
use ThingsTelemetry\Traccar\Requests\User\CreateUser;
use ThingsTelemetry\Traccar\Requests\User\DeleteUser;
use ThingsTelemetry\Traccar\Requests\User\UpdateUser;
use ThingsTelemetry\Traccar\Requests\User\GetAllUsers;
use ThingsTelemetry\Traccar\Requests\User\GenerateTotpSecret;

beforeEach(closure: function () {
    $this->user = [
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

test(description: 'it can get all users', closure: function () {
    MockClient::global(mockData: [
        GetAllUsers::class => MockResponse::make([$this->user]),
    ]);

    $response = User::all();

    expect(value: $response)
        ->toBeArray()
        ->and(value: $response[0])->toBeInstanceOf(class: UserData::class);
});

test(description: 'it can get a user by id', closure: function () {
    MockClient::global(mockData: [
        GetUser::class => MockResponse::make($this->user),
    ]);

    $user = User::get(id: 6);

    expect(value: $user)
        ->toBeInstanceOf(class: UserData::class)
        ->and(value: $user->id)->toEqual(expected: 6);
});

test(description: 'it can create a user', closure: function () {
    MockClient::global(mockData: [
        CreateUser::class => MockResponse::make($this->user),
    ]);

    $response = User::create(data: UserData::fromArray(data: $this->user));

    expect(value: $response)
        ->toBeInstanceOf(class: UserData::class)
        ->and(value: $response->id)->toEqual(expected: 6);
});

test(description: 'it can update a user', closure: function () {
    MockClient::global(mockData: [
        UpdateUser::class => MockResponse::make($this->user),
    ]);

    $response = User::update(data: UserData::fromArray(data: $this->user));

    expect(value: $response)
        ->toBeInstanceOf(class: UserData::class)
        ->and(value: $response->id)->toEqual(expected: 6);
});

test(description: 'it can delete a user', closure: function () {
    MockClient::global(mockData: [
        DeleteUser::class => MockResponse::make(body: '', status: 204),
    ]);

    $result = User::delete(id: 6);

    expect(value: $result)
        ->toBeInstanceOf(class: StatusData::class)
        ->and(value: $result->status)->toEqual(expected: Status::SUCCESS);
});

test(description: 'it can generate totp secret', closure: function () {
    MockClient::global(mockData: [
        GenerateTotpSecret::class => MockResponse::make(body: 'K5S7N7G5K5S7N7G5'),
    ]);

    $secret = User::generateTotpSecret();

    expect(value: $secret)
        ->toBeString()
        ->toEqual(expected: 'K5S7N7G5K5S7N7G5');
});
