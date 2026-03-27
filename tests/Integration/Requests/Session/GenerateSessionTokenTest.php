<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\Session;

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\TraccarConnector;
use ThingsTelemetry\Traccar\Dto\SessionTokenData;
use ThingsTelemetry\Traccar\Requests\Session\GenerateSessionToken;

beforeEach(closure: function () {
    $this->connector = new TraccarConnector(
        baseUrl: 'https://demo.traccar.org/api',
        apiKey: 'test-api-key'
    );
});

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new GenerateSessionToken();

    expect(value: $request->resolveEndpoint())->toBe(expected: '/session/token')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'GET');
});

test(description: 'it creates a SessionTokenData DTO from response via createDtoFromResponse', closure: function () {
    $mockClient = new MockClient(mockData: [
        GenerateSessionToken::class => MockResponse::make(body: 'abc123xyz789', status: 200),
    ]);

    $request = new GenerateSessionToken();
    $response = $this->connector->send(request: $request, mockClient: $mockClient);

    $token = $response->dtoOrFail();

    expect(value: $token)->toBeInstanceOf(class: SessionTokenData::class)
        ->and(value: $token->token)->toBe(expected: 'abc123xyz789');
});
