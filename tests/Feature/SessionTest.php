<?php

declare(strict_types=1);

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\UserData;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Facades\Session;
use Saloon\Exceptions\Request\RequestException;
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

describe(description: 'current', tests: function () use ($getUserData) {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new GetSession();

        expect(value: $request->resolveEndpoint())->toBe(expected: '/session')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET);
    });

    test(description: 'returns the current session', closure: function () use ($getUserData) {
        MockClient::global(mockData: [
            GetSession::class => MockResponse::make($getUserData()),
        ]);

        $user = Session::current();

        expect(value: $user)
            ->toBeInstanceOf(class: UserData::class)
            ->and(value: $user->id)->toBe(expected: 6);
    });

    test(description: 'returns the current session with a token', closure: function () use ($getUserData) {
        MockClient::global(mockData: [
            GetSession::class => function ($request) use ($getUserData) {
                expect(value: $request->query()->get(key: 'token'))->toBe(expected: 'abc123xyz789');

                return MockResponse::make(body: $getUserData());
            },
        ]);

        $user = Session::current(token: 'abc123xyz789');

        expect(value: $user)
            ->toBeInstanceOf(class: UserData::class)
            ->and(value: $user->id)->toBe(expected: 6);
    });

    test(description: 'surfaces error for current session failure', closure: function () {
        MockClient::global(mockData: [
            GetSession::class => MockResponse::make(body: ['error' => 'Unauthorized'], status: 401),
        ]);

        expect(fn () => Session::current(token: 'abc123xyz789'))->toThrow(exception: RequestException::class);
    });
});

describe(description: 'for user', tests: function () use ($getUserData) {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new GetSessionById(userId: 6);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/session/6')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET);
    });

    test(description: 'returns the session for a user id', closure: function () use ($getUserData) {
        MockClient::global(mockData: [
            GetSessionById::class => MockResponse::make($getUserData()),
        ]);

        $user = Session::forUser(userId: 6);

        expect(value: $user)
            ->toBeInstanceOf(class: UserData::class)
            ->and(value: $user->id)->toBe(expected: 6);
    });
});

describe(description: 'create', tests: function () use ($getUserData) {
    test(description: 'request sends the correct body', closure: function () {
        $request = new CreateSession(email: 'jane@example.com', password: 'secret123');

        expect(value: $request->resolveEndpoint())->toBe(expected: '/session')
            ->and(value: $request->getMethod())->toBe(expected: Method::POST)
            ->and(value: $request->body()->all())->toBe(expected: [
                'email'    => 'jane@example.com',
                'password' => 'secret123',
            ]);
    });

    test(description: 'creates a session', closure: function () use ($getUserData) {
        MockClient::global(mockData: [
            CreateSession::class => MockResponse::make($getUserData()),
        ]);

        $user = Session::create(email: 'jane@example.com', password: 'secret123');

        expect(value: $user)
            ->toBeInstanceOf(class: UserData::class)
            ->and(value: $user->id)->toBe(expected: 6);
    });

    test(description: 'creates a session with a TOTP code', closure: function () use ($getUserData) {
        MockClient::global(mockData: [
            CreateSession::class => function ($request) use ($getUserData) {
                expect(value: $request->body()->get(key: 'code'))->toBe(expected: '012345');

                return MockResponse::make(body: $getUserData());
            },
        ]);

        $user = Session::create(email: 'jane@example.com', password: 'secret123', code: '012345');

        expect(value: $user)
            ->toBeInstanceOf(class: UserData::class)
            ->and(value: $user->id)->toBe(expected: 6);
    });
});

describe(description: 'delete', tests: function () {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new DeleteSession();

        expect(value: $request->resolveEndpoint())->toBe(expected: '/session')
            ->and(value: $request->getMethod())->toBe(expected: Method::DELETE);
    });

    test(description: 'deletes the current session', closure: function () {
        MockClient::global(mockData: [
            DeleteSession::class => MockResponse::make(body: '', status: 200),
        ]);

        $result = Session::delete();

        expect(value: $result)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
    });
});

describe(description: 'generate token', tests: function () {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new GenerateSessionToken();

        expect(value: $request->resolveEndpoint())->toBe(expected: '/session/token')
            ->and(value: $request->getMethod())->toBe(expected: Method::POST);
    });

    test(description: 'generates a session token', closure: function () {
        MockClient::global(mockData: [
            GenerateSessionToken::class => MockResponse::make('abc123xyz789'),
        ]);

        $tokenData = Session::generateToken();

        expect(value: $tokenData)
            ->toBeInstanceOf(class: SessionTokenData::class)
            ->and(value: $tokenData->token)->toBe(expected: 'abc123xyz789');
    });
});

describe(description: 'revoke token', tests: function () {
    test(description: 'request sends the correct body', closure: function () {
        $request = new RevokeSessionToken(token: 'abc123xyz789');

        expect(value: $request->resolveEndpoint())->toBe(expected: '/session/token/revoke')
            ->and(value: $request->getMethod())->toBe(expected: Method::POST)
            ->and(value: $request->body()->all())->toBe(expected: ['token' => 'abc123xyz789']);
    });

    test(description: 'revokes a session token', closure: function () {
        MockClient::global(mockData: [
            RevokeSessionToken::class => MockResponse::make(body: '', status: 200),
        ]);

        $result = Session::revokeToken(token: 'abc123xyz789');

        expect(value: $result)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
    });
});

describe(description: 'get openid auth url', tests: function () {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new GetOpenIdAuth();

        expect(value: $request->resolveEndpoint())->toBe(expected: '/session/openid/auth')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET);
    });

    test(description: 'returns the openid auth url', closure: function () {
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
});

describe(description: 'handle openid callback', tests: function () {
    test(description: 'request sends the correct query string', closure: function () {
        $request = new GetOpenIdCallback(queryString: 'code=authcode&state=xyz');

        expect(value: $request->resolveEndpoint())->toBe(expected: '/session/openid/callback')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET)
            ->and(value: $request->query()->all())->toBe(expected: [
                'code'  => 'authcode',
                'state' => 'xyz',
            ]);
    });

    test(description: 'returns the callback redirect url', closure: function () {
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
});
