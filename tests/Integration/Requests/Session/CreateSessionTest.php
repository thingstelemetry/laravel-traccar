<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\Session;

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\UserData;
use ThingsTelemetry\Traccar\TraccarConnector;
use ThingsTelemetry\Traccar\Requests\Session\CreateSession;

beforeEach(closure: function () {
    $this->connector = new TraccarConnector(
        baseUrl: 'https://demo.traccar.org/api',
        apiKey: 'test-api-key'
    );
});

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new CreateSession(email: 'jane@example.com', password: 'secret123');

    expect(value: $request->resolveEndpoint())->toBe(expected: '/session')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'POST');
});

test(description: 'it sends the correct body', closure: function () {
    $request = new CreateSession(email: 'jane@example.com', password: 'secret123');

    expect(value: $request->body()->all())->toBe(expected: [
        'email'    => 'jane@example.com',
        'password' => 'secret123',
    ]);
});

test(description: 'it creates a UserData DTO from response via createDtoFromResponse', closure: function () {
    $payload = [
        'id'    => 6,
        'email' => 'jane@example.com',
    ];

    $mockClient = new MockClient(mockData: [
        CreateSession::class => MockResponse::make(body: $payload, status: 200),
    ]);

    $request = new CreateSession(email: 'jane@example.com', password: 'secret123');
    $response = $this->connector->send(request: $request, mockClient: $mockClient);

    $user = $response->dtoOrFail();

    expect(value: $user)->toBeInstanceOf(class: UserData::class)
        ->and(value: $user->email)->toBe(expected: 'jane@example.com');
});
