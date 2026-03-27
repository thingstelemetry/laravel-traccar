<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\Group;

use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\GroupData;
use ThingsTelemetry\Traccar\TraccarConnector;
use ThingsTelemetry\Traccar\Requests\Group\GetAllGroups;

beforeEach(closure: function () {
    $this->connector = new TraccarConnector(
        baseUrl: 'https://demo.traccar.org/api',
        apiKey: 'test-api-key'
    );
});

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new GetAllGroups();

    expect(value: $request->resolveEndpoint())->toBe(expected: '/groups')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'GET');
});

test(description: 'it creates a collection of GroupData DTOs from response via createDtoFromResponse', closure: function () {
    $payload = [
        [
            'id'   => 1,
            'name' => 'Vehicles',
        ],
    ];

    $mockClient = new MockClient(mockData: [
        GetAllGroups::class => MockResponse::make(body: $payload, status: 200),
    ]);

    $request = new GetAllGroups();
    $response = $this->connector->send(request: $request, mockClient: $mockClient);

    $groups = $response->dtoOrFail();

    expect(value: $groups)->toBeInstanceOf(class: Collection::class)
        ->and(value: $groups)->toHaveCount(1)
        ->and(value: $groups->first())->toBeInstanceOf(class: GroupData::class);
});
