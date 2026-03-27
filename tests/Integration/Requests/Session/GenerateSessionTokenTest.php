<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\SessionTokenData;
use ThingsTelemetry\Traccar\Requests\Session\GenerateSessionToken;

test(description: 'it can generate session token', closure: function () {
    $mockClient = new MockClient(mockData: [
        GenerateSessionToken::class => MockResponse::make(body: 'abc123xyz789'),
    ]);

    $request = new GenerateSessionToken();
    $response = connector()->send(request: $request, mockClient: $mockClient);

    expect(value: $response->dto())
        ->toBeInstanceOf(class: SessionTokenData::class)
        ->and(value: $response->dto()->token)->toBe('abc123xyz789');
});
