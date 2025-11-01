<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use TrackTelemetry\Traccar\Enums\Map;
use TrackTelemetry\Traccar\Dto\UserData;
use TrackTelemetry\Traccar\Facades\User;
use TrackTelemetry\Traccar\Requests\GetUser;
use TrackTelemetry\Traccar\Enums\CoordinateFormat;
use Saloon\Exceptions\Request\Statuses\NotFoundException;

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
        'attributes'       => ['notify' => true],
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
        ->toHaveKey(key: 'notify', value: true);
});

it(description: 'throws JsonException on invalid JSON response', closure: function () {
    MockClient::global(mockData: [
        GetUser::class => MockResponse::make('not-json', 200, ['Content-Type' => 'application/json']),
    ]);

    expect(value: fn () => User::get(1))->toThrow(exception: JsonException::class);
});

it(description: 'throws NotFoundException when user is missing', closure: function () {
    MockClient::global(mockData: [
        GetUser::class => MockResponse::make([], 200),
    ]);

    expect(value: fn () => User::get(999))->toThrow(exception: NotFoundException::class);
});
