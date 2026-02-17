<?php

declare(strict_types=1);

use Carbon\Carbon;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\UserData;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Facades\Session;
use Saloon\Exceptions\Request\RequestException;
use ThingsTelemetry\Traccar\Requests\GetSession;
use ThingsTelemetry\Traccar\Dto\SessionTokenData;
use ThingsTelemetry\Traccar\Requests\CreateSession;
use ThingsTelemetry\Traccar\Requests\DeleteSession;
use ThingsTelemetry\Traccar\Requests\GetOpenIdAuth;
use ThingsTelemetry\Traccar\Requests\GetSessionById;
use ThingsTelemetry\Traccar\Requests\GetOpenIdCallback;
use ThingsTelemetry\Traccar\Requests\RevokeSessionToken;
use ThingsTelemetry\Traccar\Requests\GenerateSessionToken;

$getUserData = fn () => [
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

describe(description: 'Get Session', tests: function () use ($getUserData) {
    it(description: 'can get current session', closure: function () use ($getUserData) {
        MockClient::global(mockData: [
            GetSession::class => MockResponse::make($getUserData()),
        ]);

        $user = Session::get();

        expect(value: $user)
            ->toBeInstanceOf(class: UserData::class)
            ->and(value: $user->id)->toBe(expected: 6)
            ->and(value: $user->email)->toBe(expected: 'jane@example.com');
    });

    it(description: 'can get session with token verification', closure: function () use ($getUserData) {
        MockClient::global(mockData: [
            GetSession::class => MockResponse::make($getUserData()),
        ]);

        $user = Session::get(token: 'abc123');

        expect(value: $user)
            ->toBeInstanceOf(class: UserData::class)
            ->and(value: $user->id)->toBe(expected: 6);
    });

    it(description: 'throws exception when not authenticated', closure: function () use ($getUserData) {
        MockClient::global(mockData: [
            GetSession::class => MockResponse::make([], 404),
        ]);

        Session::get();
    })->throws(exception: RequestException::class);
});

describe(description: 'Get Session By ID', tests: function () use ($getUserData) {
    it(description: 'can get session by user ID', closure: function () use ($getUserData) {
        MockClient::global(mockData: [
            GetSessionById::class => MockResponse::make($getUserData()),
        ]);

        $user = Session::getById(userId: 6);

        expect(value: $user)
            ->toBeInstanceOf(class: UserData::class)
            ->and(value: $user->id)->toBe(expected: 6)
            ->and(value: $user->name)->toBe(expected: 'Jane Doe');
    });

    it(description: 'throws exception for forbidden access', closure: function () use ($getUserData) {
        MockClient::global(mockData: [
            GetSessionById::class => MockResponse::make([], 403),
        ]);

        Session::getById(userId: 6);
    })->throws(exception: RequestException::class);

    it(description: 'throws exception for non-existent user', closure: function () use ($getUserData) {
        MockClient::global(mockData: [
            GetSessionById::class => MockResponse::make([], 404),
        ]);

        Session::getById(userId: 99999);
    })->throws(exception: RequestException::class);
});

describe(description: 'Create Session (Login)', tests: function () use ($getUserData) {
    it(description: 'can create session with email and password', closure: function () use ($getUserData) {
        MockClient::global(mockData: [
            CreateSession::class => MockResponse::make($getUserData()),
        ]);

        $user = Session::create(
            email: 'jane@example.com',
            password: 'secret123'
        );

        expect(value: $user)
            ->toBeInstanceOf(class: UserData::class)
            ->and(value: $user->email)->toBe(expected: 'jane@example.com');
    });

    it(description: 'can create session with TOTP code', closure: function () use ($getUserData) {
        MockClient::global(mockData: [
            CreateSession::class => MockResponse::make($getUserData()),
        ]);

        $user = Session::create(
            email: 'jane@example.com',
            password: 'secret123',
            code: 123456
        );

        expect(value: $user)
            ->toBeInstanceOf(class: UserData::class)
            ->and(value: $user->id)->toBe(expected: 6);
    });

    it(description: 'throws exception on invalid credentials', closure: function () use ($getUserData) {
        MockClient::global(mockData: [
            CreateSession::class => MockResponse::make([], 401),
        ]);

        Session::create(
            email: 'jane@example.com',
            password: 'wrong-password'
        );
    })->throws(exception: RequestException::class);
});

describe(description: 'Delete Session (Logout)', tests: function () {
    it(description: 'can delete session', closure: function () {
        MockClient::global(mockData: [
            DeleteSession::class => MockResponse::make(body: '', status: 200),
        ]);

        $result = Session::delete();

        expect(value: $result)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
    });
});

describe(description: 'Generate Session Token', tests: function () {
    it(description: 'can generate token without expiration', closure: function () {
        MockClient::global(mockData: [
            GenerateSessionToken::class => MockResponse::make('abc123xyz789'),
        ]);

        $tokenData = Session::generateToken();

        expect(value: $tokenData)
            ->toBeInstanceOf(class: SessionTokenData::class)
            ->and(value: $tokenData->token)->toBe(expected: 'abc123xyz789');
    });

    it(description: 'can generate token with expiration', closure: function () {
        MockClient::global(mockData: [
            GenerateSessionToken::class => MockResponse::make('token-with-expiry'),
        ]);

        $expiration = Carbon::now()->addDays(30);
        $tokenData = Session::generateToken($expiration);

        expect(value: $tokenData)
            ->toBeInstanceOf(class: SessionTokenData::class)
            ->and(value: $tokenData->token)->toBe(expected: 'token-with-expiry');
    });
});

describe(description: 'Revoke Session Token', tests: function () {
    it(description: 'can revoke token', closure: function () {
        MockClient::global(mockData: [
            RevokeSessionToken::class => MockResponse::make(body: '', status: 200),
        ]);

        $result = Session::revokeToken(token: 'abc123xyz789');

        expect(value: $result)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
    });

    it(description: 'throws exception for invalid token', closure: function () {
        MockClient::global(mockData: [
            RevokeSessionToken::class => MockResponse::make([], 400),
        ]);

        Session::revokeToken(token: 'invalid-token');
    })->throws(exception: RequestException::class);
});

describe(description: 'OpenID Auth', tests: function () {
    it(description: 'can get OpenID auth URL', closure: function () {
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

    it(description: 'returns empty string when Location header is missing', closure: function () {
        MockClient::global(mockData: [
            GetOpenIdAuth::class => MockResponse::make(body: '', status: 303),
        ]);

        $authUrl = Session::getOpenIdAuthUrl();

        expect(value: $authUrl)->toBe(expected: '');
    });
});

describe(description: 'OpenID Callback', tests: function () {
    it(description: 'can handle OpenID callback', closure: function () {
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

    it(description: 'returns empty string when Location header is missing', closure: function () {
        MockClient::global(mockData: [
            GetOpenIdCallback::class => MockResponse::make(body: '', status: 303),
        ]);

        $redirectUrl = Session::handleOpenIdCallback(queryString: 'code=authcode');

        expect(value: $redirectUrl)->toBe(expected: '');
    });
});

describe(description: 'Session Token Data', tests: function () {
    it(description: 'can be serialized to array', closure: function () {
        $tokenData = new SessionTokenData(token: 'test-token-123');
        $array = $tokenData->toArray();

        expect(value: $array)
            ->toBe(expected: ['token' => 'test-token-123']);
    });

    it(description: 'can be created from string', closure: function () {
        $tokenData = SessionTokenData::fromString(token: 'from-string-token');

        expect(value: $tokenData->token)->toBe(expected: 'from-string-token');
    });
});
