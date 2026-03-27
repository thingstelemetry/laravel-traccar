<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\UserData;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Facades\Session;
use ThingsTelemetry\Traccar\Dto\SessionTokenData;
use ThingsTelemetry\Traccar\Requests\Session\GetSession;
use ThingsTelemetry\Traccar\Requests\Session\CreateSession;
use ThingsTelemetry\Traccar\Requests\Session\DeleteSession;
use ThingsTelemetry\Traccar\Requests\Session\GetOpenIdAuth;
use ThingsTelemetry\Traccar\Requests\Session\GetSessionById;
use ThingsTelemetry\Traccar\Requests\Session\GetOpenIdCallback;
use ThingsTelemetry\Traccar\Requests\Session\RevokeSessionToken;
use ThingsTelemetry\Traccar\Requests\Session\GenerateSessionToken;

$getUserData = fn () => [
    'id'    => 6,
    'email' => 'jane@example.com',
];

test(description: 'can get current session', closure: function () use ($getUserData) {
    MockClient::global(mockData: [
        GetSession::class => MockResponse::make($getUserData()),
    ]);

    $user = Session::get();

    expect(value: $user)
        ->toBeInstanceOf(class: UserData::class)
        ->and(value: $user->id)->toBe(expected: 6);
});

test(description: 'can get session by user ID', closure: function () use ($getUserData) {
    MockClient::global(mockData: [
        GetSessionById::class => MockResponse::make($getUserData()),
    ]);

    $user = Session::getById(userId: 6);

    expect(value: $user)
        ->toBeInstanceOf(class: UserData::class)
        ->and(value: $user->id)->toBe(expected: 6);
});

test(description: 'can create session', closure: function () use ($getUserData) {
    MockClient::global(mockData: [
        CreateSession::class => MockResponse::make($getUserData()),
    ]);

    $user = Session::create(
        email: 'jane@example.com',
        password: 'secret123'
    );

    expect(value: $user)
        ->toBeInstanceOf(class: UserData::class)
        ->and(value: $user->id)->toBe(expected: 6);
});

test(description: 'can delete session', closure: function () {
    MockClient::global(mockData: [
        DeleteSession::class => MockResponse::make(body: '', status: 200),
    ]);

    $result = Session::delete();

    expect(value: $result)
        ->toBeInstanceOf(class: StatusData::class)
        ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
});

test(description: 'can generate session token', closure: function () {
    MockClient::global(mockData: [
        GenerateSessionToken::class => MockResponse::make('abc123xyz789'),
    ]);

    $tokenData = Session::generateToken();

    expect(value: $tokenData)
        ->toBeInstanceOf(class: SessionTokenData::class)
        ->and(value: $tokenData->token)->toBe(expected: 'abc123xyz789');
});

test(description: 'can revoke session token', closure: function () {
    MockClient::global(mockData: [
        RevokeSessionToken::class => MockResponse::make(body: '', status: 200),
    ]);

    $result = Session::revokeToken(token: 'abc123xyz789');

    expect(value: $result)
        ->toBeInstanceOf(class: StatusData::class)
        ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
});

test(description: 'can get OpenID auth URL', closure: function () {
    MockClient::global(mockData: [
        GetOpenIdAuth::class => MockResponse::make(
            body: '',
            status: 303,
            headers: ['Location' => 'https://accounts.google.com/o/oauth2/auth?client_id=xxx']
        ),
    ]);

    $authUrl = Session::getOpenIdAuthUrl();

    expect(value: $authUrl)->toBe(expected: 'https://accounts.google.com/o/oauth2/auth?client_id=xxx');
});

test(description: 'can handle OpenID callback', closure: function () {
    MockClient::global(mockData: [
        GetOpenIdCallback::class => MockResponse::make(
            body: '',
            status: 303,
            headers: ['Location' => '/dashboard?token=xyz789']
        ),
    ]);

    $redirectUrl = Session::handleOpenIdCallback(queryString: 'code=authcode&state=xyz');

    expect(value: $redirectUrl)->toBe(expected: '/dashboard?token=xyz789');
});
