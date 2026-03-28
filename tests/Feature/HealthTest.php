<?php

declare(strict_types=1);

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Facades\Health;
use ThingsTelemetry\Traccar\Requests\Health\GetHealth;

describe(description: 'health', tests: function () {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new GetHealth();

        expect(value: $request->resolveEndpoint())->toBe(expected: '/health')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET)
            ->and(value: $request->headers()->get('Accept'))->toBe(expected: 'text/plain, */*');
    });

    test(description: 'returns the plain text health status', closure: function () {
        MockClient::global(mockData: [
            GetHealth::class => MockResponse::make(body: 'OK'),
        ]);

        expect(value: Health::check())->toBe(expected: 'OK');
    });

    test(description: 'propagates errors', closure: function () {
        MockClient::global(mockData: [
            GetHealth::class => MockResponse::make(body: 'Service Unavailable', status: 503),
        ]);

        expect(value: fn () => Health::check())
            ->toThrow(exception: \Saloon\Exceptions\Request\RequestException::class);
    });
});
