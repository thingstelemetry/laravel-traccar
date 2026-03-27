<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\Group;

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\GroupData;
use ThingsTelemetry\Traccar\TraccarConnector;
use ThingsTelemetry\Traccar\Requests\Group\GetGroup;
use Saloon\Exceptions\Request\Statuses\NotFoundException;

beforeEach(closure: function () {
    $this->connector = new TraccarConnector(
        baseUrl: 'https://demo.traccar.org/api',
        apiKey: 'test-api-key'
    );
});

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new GetGroup(id: 1);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/groups/1')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'GET');
});

test(description: 'it creates a GroupData DTO from response via createDtoFromResponse', closure: function () {
    $body = [
        'id'         => 1,
        'name'       => 'Vehicles',
        'groupId'    => null,
        'attributes' => [
            'color' => 'red'
        ],
    ];

    $mockClient = new MockClient(mockData: [
        GetGroup::class => MockResponse::make(body: $body, status: 200),
    ]);

    $request = new GetGroup(id: 1);
    $response = $this->connector->send(request: $request, mockClient: $mockClient);

    $group = $response->dtoOrFail();

    expect(value: $group)->toBeInstanceOf(class: GroupData::class)
        ->and(value: $group->id)->toBe(1)
        ->and(value: $group->name)->toBe('Vehicles')
        ->and(value: $group->attributes['color'])->toBe('red');
});

test(description: 'it throws NotFoundException for empty group body via createDtoFromResponse', closure: function () {
    $mockClient = new MockClient(mockData: [
        GetGroup::class => MockResponse::make(body: [], status: 200),
    ]);

    $request = new GetGroup(id: 999);

    expect(value: fn () => $this->connector->send(request: $request, mockClient: $mockClient)->dtoOrFail())
        ->toThrow(exception: NotFoundException::class, exceptionMessage: 'Traccar group was not found. Check the group ID and try again.');
});
