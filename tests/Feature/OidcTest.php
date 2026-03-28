<?php

declare(strict_types=1);

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Facades\Oidc;
use ThingsTelemetry\Traccar\Dto\OidcTokenData;
use ThingsTelemetry\Traccar\Dto\JwksResponseDto;
use ThingsTelemetry\Traccar\Dto\OidcUserInfoData;
use ThingsTelemetry\Traccar\Requests\Oidc\GetJwks;
use ThingsTelemetry\Traccar\Requests\Oidc\GetToken;
use ThingsTelemetry\Traccar\Requests\Oidc\Authorize;
use ThingsTelemetry\Traccar\Requests\Oidc\GetUserInfo;

describe('authorize', function () {
    test('request resolves the correct endpoint', function () {
        $request = new Authorize(
            clientId: 'client-id',
            redirectUri: 'https://example.com/callback',
            state: 'state-123',
            scope: 'openid profile',
        );

        expect($request->resolveEndpoint())->toBe('/oidc/authorize')
            ->and($request->getMethod())->toBe(Method::GET)
            ->and($request->query()->all())->toMatchArray([
                'client_id'    => 'client-id',
                'redirect_uri' => 'https://example.com/callback',
                'state'        => 'state-123',
                'scope'        => 'openid profile',
            ]);
    });

    test('returns authorize location via facade', function () {
        MockClient::global([
            Authorize::class => MockResponse::make(
                body: '',
                status: 303,
                headers: ['Location' => 'https://example.com/callback?code=abc&state=state-123'],
            ),
        ]);

        $location = Oidc::authorize(
            clientId: 'client-id',
            redirectUri: 'https://example.com/callback',
            state: 'state-123',
        );

        expect($location)->toBe('https://example.com/callback?code=abc&state=state-123');
    });

    test('surfaces error for a missing Location header in authorize', function () {
        MockClient::global([
            Authorize::class => MockResponse::make(
                body: '',
                status: 200,
                headers: [],
            ),
        ]);

        expect(fn () => Oidc::authorize(
            clientId: 'client-id',
            redirectUri: 'https://example.com/callback',
        ))->toThrow(\Saloon\Exceptions\Request\FatalRequestException::class, 'OIDC authorize failed: Location header is missing from the response.');
    });

    test('propagates errors in authorize', function () {
        MockClient::global([
            Authorize::class => MockResponse::make(body: [], status: 500),
        ]);

        expect(fn () => Oidc::authorize(
            clientId: 'client-id',
            redirectUri: 'https://example.com/callback',
        ))->toThrow(\Saloon\Exceptions\Request\RequestException::class);
    });
});

describe('getToken', function () {
    test('request resolves the correct endpoint', function () {
        $request = new GetToken(
            grantType: 'authorization_code',
            code: 'abc',
            redirectUri: 'https://example.com/callback',
        );

        expect($request->resolveEndpoint())->toBe('/oidc/token')
            ->and($request->getMethod())->toBe(Method::POST)
            ->and($request->body()->all())->toMatchArray([
                'grant_type'   => 'authorization_code',
                'code'         => 'abc',
                'redirect_uri' => 'https://example.com/callback',
            ]);
    });

    test('returns token information via facade', function () {
        $payload = [
            'access_token' => 'access-token',
            'token_type'   => 'Bearer',
            'expires_in'   => 3600,
            'id_token'     => 'id-token',
            'scope'        => 'openid profile',
        ];

        MockClient::global([
            GetToken::class => MockResponse::make($payload),
        ]);

        $response = Oidc::getToken(
            grantType: 'authorization_code',
            code: 'abc',
        );

        expect($response)->toBeInstanceOf(OidcTokenData::class)
            ->and($response->accessToken)->toBe('access-token')
            ->and($response->expiresIn)->toBe(3600);
    });

    test('propagates errors in get token', function () {
        MockClient::global([
            GetToken::class => MockResponse::make(body: [], status: 500),
        ]);

        expect(fn () => Oidc::getToken(
            grantType: 'authorization_code',
            code: 'abc',
        ))->toThrow(\Saloon\Exceptions\Request\RequestException::class);
    });
});

describe('getUserInfo', function () {
    test('request resolves the correct endpoint', function () {
        $request = new GetUserInfo();

        expect($request->resolveEndpoint())->toBe('/oidc/userinfo')
            ->and($request->getMethod())->toBe(Method::GET);
    });

    test('returns user info via facade', function () {
        $payload = [
            'sub'   => '1',
            'name'  => 'Admin',
            'email' => 'admin@example.com',
        ];

        MockClient::global([
            GetUserInfo::class => MockResponse::make($payload),
        ]);

        $response = Oidc::getUserInfo();

        expect($response)->toBeInstanceOf(OidcUserInfoData::class)
            ->and($response->sub)->toBe('1')
            ->and($response->name)->toBe('Admin');
    });

    test('surfaces error for a non-2xx response in get user info', function () {
        MockClient::global([
            GetUserInfo::class => MockResponse::make(body: ['error' => 'Unauthorized'], status: 401),
        ]);

        try {
            Oidc::getUserInfo();
            $this->fail('Expected RequestException was not thrown');
        } catch (\Saloon\Exceptions\Request\RequestException $e) {
            expect($e->getResponse()->status())->toBe(401);
        }
    });
});

describe('getJwks', function () {
    test('request resolves the correct endpoint', function () {
        $request = new GetJwks();

        expect($request->resolveEndpoint())->toBe('/oidc/jwks')
            ->and($request->getMethod())->toBe(Method::GET);
    });

    test('returns jwks via facade', function () {
        $payload = [
            'keys' => [
                [
                    'kty' => 'RSA',
                    'alg' => 'RS256',
                    'use' => 'sig',
                    'kid' => '1',
                    'n'   => 'n',
                    'e'   => 'e',
                ],
            ],
        ];

        MockClient::global([
            GetJwks::class => MockResponse::make($payload),
        ]);

        $response = Oidc::getJwks();

        expect($response)->toBeInstanceOf(JwksResponseDto::class)
            ->and($response->keys->first()->kty)->toBe('RSA');
    });

    test('surfaces error for a non-2xx response in get jwks', function () {
        MockClient::global([
            GetJwks::class => MockResponse::make(body: ['error' => 'Bad request'], status: 400),
        ]);

        try {
            Oidc::getJwks();
            $this->fail('Expected RequestException was not thrown');
        } catch (\Saloon\Exceptions\Request\RequestException $e) {
            expect($e->getResponse()->status())->toBe(400);
        }
    });
});
