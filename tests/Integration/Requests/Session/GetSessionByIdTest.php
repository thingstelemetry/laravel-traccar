<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\Session;

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\UserData;
use ThingsTelemetry\Traccar\TraccarConnector;
use ThingsTelemetry\Traccar\Requests\Session\GetSessionById;

beforeEach(closure: function () {
    $this->connector = new TraccarConnector(
        baseUrl: 'https://demo.traccar.org/api',
        apiKey: 'test-api-key'
    );
});

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new GetSessionById(userId: 1);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/session/1')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'GET');
});

test(description: 'it creates a UserData DTO from response via createDtoFromResponse', closure: function () {
    $body = [
        'id'       => 1,
        'name'     => 'Admin',
        'email'    => 'admin@example.com',
        'admin'    => true,
        'disabled' => false,
    ];

    $mockClient = new MockClient(mockData: [
        GetSessionById::class => MockResponse::make(body: $body, status: 200),
    ]);

    $request = new GetSessionById(userId: 1);
    $response = $this->connector->send(request: $request, mockClient: $mockClient);

    $user = $response->dtoOrFail();

    expect(value: $user)->toBeInstanceOf(class: UserData::class)
        ->and(value: $user->id)->toBe(expected: 1)
        ->and(value: $user->name)->toBe(expected: 'Admin');
});
