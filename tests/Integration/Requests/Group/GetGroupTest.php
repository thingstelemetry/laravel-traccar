<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\GroupData;
use ThingsTelemetry\Traccar\Requests\Group\GetGroup;
use Saloon\Exceptions\Request\Statuses\NotFoundException;

test(description: 'it can get a single group by id', closure: function () {
    $body = [
        'id'         => 1,
        'name'       => 'Vehicles',
        'groupId'    => null,
        'attributes' => [
            'color' => 'red'
        ],
    ];

    $mockClient = new MockClient(mockData: [
        GetGroup::class => MockResponse::make(body: $body),
    ]);

    $request = new GetGroup(id: 1);
    $response = connector()->send(request: $request, mockClient: $mockClient);

    expect(value: $response->dto())
        ->toBeInstanceOf(class: GroupData::class)
        ->and(value: $response->dto()->id)->toBe(1)
        ->and(value: $response->dto()->name)->toBe('Vehicles')
        ->and(value: $response->dto()->attributes['color'])->toBe('red');
});

test(description: 'it throws NotFoundException for empty group body', closure: function () {
    $mockClient = new MockClient(mockData: [
        GetGroup::class => MockResponse::make(body: [], status: 200),
    ]);

    $request = new GetGroup(id: 999);

    expect(value: fn () => connector()->send(request: $request, mockClient: $mockClient)->dto())
        ->toThrow(exception: NotFoundException::class, message: 'Traccar group was not found. Check the group ID and try again.');
});

test(description: 'it throws NotFoundException for HTTP 404', closure: function () {
    $mockClient = new MockClient(mockData: [
        GetGroup::class => MockResponse::make(body: ['error' => 'Not found'], status: 404),
    ]);

    $request = new GetGroup(id: 999);

    expect(value: fn () => connector()->send(request: $request, mockClient: $mockClient)->dto())
        ->toThrow(exception: NotFoundException::class);
});
