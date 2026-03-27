<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\UserData;
use ThingsTelemetry\Traccar\Requests\Session\GetSessionById;

test(description: 'it can get a session by user id', closure: function () {
    $body = [
        'id'       => 1,
        'name'     => 'Admin',
        'email'    => 'admin@example.com',
        'admin'    => true,
        'disabled' => false,
    ];

    $mockClient = new MockClient(mockData: [
        GetSessionById::class => MockResponse::make(body: $body),
    ]);

    $request = new GetSessionById(userId: 1);
    $response = connector()->send(request: $request, mockClient: $mockClient);

    expect(value: $response->dto())
        ->toBeInstanceOf(class: UserData::class)
        ->and(value: $response->dto()->id)->toBe(1)
        ->and(value: $response->dto()->name)->toBe('Admin');
});
