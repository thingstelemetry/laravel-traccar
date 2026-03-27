<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\UserData;
use ThingsTelemetry\Traccar\Requests\Session\CreateSession;

test(description: 'it can create session', closure: function () {
    $payload = [
        'id'    => 6,
        'email' => 'jane@example.com',
    ];

    $mockClient = new MockClient(mockData: [
        CreateSession::class => MockResponse::make(body: $payload),
    ]);

    $request = new CreateSession(email: 'jane@example.com', password: 'secret123');
    $response = connector()->send(request: $request, mockClient: $mockClient);

    expect(value: $response->dto())
        ->toBeInstanceOf(class: UserData::class)
        ->and(value: $response->dto()->email)->toBe('jane@example.com');
});
