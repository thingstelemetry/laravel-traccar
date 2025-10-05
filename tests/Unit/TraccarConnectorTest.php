<?php

declare(strict_types=1);

use Saloon\Http\Auth\TokenAuthenticator;
use TrackTelemetry\Traccar\TraccarConnector;

beforeEach(closure: function (): void {
    $this->baseUrl = 'https://demo.traccar.org/api';
    $this->apiKey = '7d3c95e72a18b4f56082139d74c6b30fa92e8f7c'; // A fake key 😊

    $this->connector = new TraccarConnector(
        baseUrl: $this->baseUrl,
        apiKey: $this->apiKey
    );
});

it(description: 'resolves the correct base url', closure: function (): void {
    expect(value: $this->connector->resolveBaseUrl())
        ->toBe(expected: $this->baseUrl);
});

it(description: 'set the secret key in the authorization header', closure: function (): void {
    $authenticator = $this->connector->getAuthenticator();

    expect(value: $authenticator)
        ->toBeInstanceOf(class: TokenAuthenticator::class)
        ->and(value: $authenticator)
        ->token->toBe(expected: $this->apiKey)
        ->prefix->toBe(expected: 'Bearer');
});

it(description: 'sets the correct default headers', closure: function (): void {
    expect(value: $this->connector->headers()->all())
        ->toBeArray()
        ->toHaveKey(key: 'Content-Type', value: 'application/json')
        ->toHaveKey(key: 'Accept', value: 'application/json');
});
