<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Tests\Feature;

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Facades\Password;
use ThingsTelemetry\Traccar\Requests\Password\ResetPassword;
use ThingsTelemetry\Traccar\Requests\Password\UpdatePassword;

describe(description: 'reset', tests: function () {
    test(description: 'request resolves the correct endpoint and body', closure: function () {
        $email = 'user@example.com';
        $request = new ResetPassword(email: $email);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/password/reset')
            ->and(value: $request->getMethod())->toBe(expected: Method::POST)
            ->and(value: $request->body()->all())->toBe(expected: ['email' => $email]);
    });

    test(description: 'returns success response via facade', closure: function () {
        MockClient::global(mockData: [
            ResetPassword::class => MockResponse::make(body: [], status: 200),
        ]);

        $response = Password::reset(email: 'user@example.com');

        expect(value: $response)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $response->status)->toBe(expected: Status::SUCCESS);
    });

    test(description: 'propagates errors', closure: function () {
        MockClient::global(mockData: [
            ResetPassword::class => MockResponse::make(body: [], status: 400),
        ]);

        expect(value: fn () => Password::reset(email: 'user@example.com'))
            ->toThrow(exception: \Saloon\Exceptions\Request\RequestException::class);
    });
});

describe(description: 'update', tests: function () {
    test(description: 'request resolves the correct endpoint and body', closure: function () {
        $token = 'secret-token';
        $password = 'new-password';
        $request = new UpdatePassword(token: $token, password: $password);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/password/update')
            ->and(value: $request->getMethod())->toBe(expected: Method::POST)
            ->and(value: $request->body()->all())->toBe(expected: [
                'token'    => $token,
                'password' => $password,
            ]);
    });

    test(description: 'returns success response via facade', closure: function () {
        MockClient::global(mockData: [
            UpdatePassword::class => MockResponse::make(body: [], status: 200),
        ]);

        $response = Password::update(token: 'token', password: 'password');

        expect(value: $response)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $response->status)->toBe(expected: Status::SUCCESS);
    });

    test(description: 'returns 404 when token is invalid via facade', closure: function () {
        MockClient::global(mockData: [
            UpdatePassword::class => MockResponse::make(body: [], status: 404),
        ]);

        expect(value: fn () => Password::update(token: 'invalid', password: 'password'))
            ->toThrow(exception: \Saloon\Exceptions\Request\RequestException::class);
    });
});
