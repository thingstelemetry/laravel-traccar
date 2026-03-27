<?php

declare(strict_types=1);

use Saloon\Http\Response;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\UserData;
use ThingsTelemetry\Traccar\Requests\Session\GetSession;

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new GetSession();

    expect(value: $request->resolveEndpoint())->toBe(expected: '/session')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'GET');
});

test(description: 'it creates a UserData DTO from response via createDtoFromResponse', closure: function () {
    $payload = [
        'id'    => 6,
        'email' => 'jane@example.com',
    ];

    $request = new GetSession();
    $response = Response::fromMock(mockResponse: MockResponse::make(body: $payload, status: 200));

    $user = $request->createDtoFromResponse(response: $response);

    expect(value: $user)->toBeInstanceOf(class: UserData::class)
        ->and(value: $user->id)->toBe(6);
});
