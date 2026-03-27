<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\UserData;
use ThingsTelemetry\Traccar\Requests\Session\GetSession;

test(description: 'it can get current session', closure: function () {
    $payload = [
        'id'    => 6,
        'email' => 'jane@example.com',
    ];

    $mockClient = new MockClient(mockData: [
        GetSession::class => MockResponse::make(body: $payload),
    ]);

    $request = new GetSession();
    $response = connector()->send(request: $request, mockClient: $mockClient);

    expect(value: $response->dto())
        ->toBeInstanceOf(class: UserData::class)
        ->and(value: $response->dto()->id)->toBe(6);
});
