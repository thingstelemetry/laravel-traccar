<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\User;

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\TraccarConnector;
use ThingsTelemetry\Traccar\Requests\User\GenerateTotpSecret;

beforeEach(closure: function () {
    $this->connector = new TraccarConnector(
        baseUrl: 'https://demo.traccar.org/api',
        apiKey: 'test-api-key'
    );
});

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new GenerateTotpSecret();

    expect(value: $request->resolveEndpoint())->toBe(expected: '/users/totp');
});

test(description: 'it returns a string response via createDtoFromResponse', closure: function () {
    $mockClient = new MockClient(mockData: [
        GenerateTotpSecret::class => MockResponse::make(body: 'K5S7N7G5K5S7N7G5', status: 200),
    ]);

    $request = new GenerateTotpSecret();
    $response = $this->connector->send(request: $request, mockClient: $mockClient);

    $secret = $response->dtoOrFail();

    expect(value: $secret)->toBeString()
        ->and(value: $secret)->toBe(expected: 'K5S7N7G5K5S7N7G5');
});
