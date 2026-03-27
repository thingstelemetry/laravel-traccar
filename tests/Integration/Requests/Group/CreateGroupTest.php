<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\GroupData;
use ThingsTelemetry\Traccar\Requests\Group\CreateGroup;

test(description: 'it can create a group', closure: function () {
    $payload = [
        'id'   => 3,
        'name' => 'New Group',
    ];

    $mockClient = new MockClient(mockData: [
        CreateGroup::class => MockResponse::make(body: $payload),
    ]);

    $data = GroupData::fromArray($payload);
    $request = new CreateGroup(data: $data);
    $response = connector()->send(request: $request, mockClient: $mockClient);

    expect(value: $response->dto())
        ->toBeInstanceOf(class: GroupData::class)
        ->and(value: $response->dto()->id)->toBe(3);
});
