<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\Group;

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\GroupData;
use ThingsTelemetry\Traccar\TraccarConnector;
use ThingsTelemetry\Traccar\Requests\Group\CreateGroup;

beforeEach(closure: function () {
    $this->connector = new TraccarConnector(
        baseUrl: 'https://demo.traccar.org/api',
        apiKey: 'test-api-key'
    );
});

test(description: 'it resolves the correct endpoint', closure: function () {
    $payload = [
        'id'   => 3,
        'name' => 'New Group',
    ];

    $data = GroupData::fromArray($payload);
    $request = new CreateGroup(data: $data);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/groups')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'POST');
});

test(description: 'it sends the correct body', closure: function () {
    $payload = [
        'id'   => 3,
        'name' => 'New Group',
    ];

    $data = GroupData::fromArray($payload);
    $request = new CreateGroup(data: $data);

    expect(value: $request->body()->all())->toBe(expected: $payload);
});

test(description: 'it creates a GroupData DTO from response via createDtoFromResponse', closure: function () {
    $payload = [
        'id'   => 3,
        'name' => 'New Group',
    ];

    $mockClient = new MockClient(mockData: [
        CreateGroup::class => MockResponse::make(body: $payload, status: 200),
    ]);

    $data = GroupData::fromArray($payload);
    $request = new CreateGroup(data: $data);
    $response = $this->connector->send(request: $request, mockClient: $mockClient);

    $group = $response->dtoOrFail();

    expect(value: $group)->toBeInstanceOf(class: GroupData::class)
        ->and(value: $group->id)->toBe(expected: 3);
});
