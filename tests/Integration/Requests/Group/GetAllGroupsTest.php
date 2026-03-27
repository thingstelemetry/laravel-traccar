<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\GroupData;
use ThingsTelemetry\Traccar\Requests\Group\GetAllGroups;

test(description: 'it can get all groups', closure: function () {
    $payload = [
        [
            'id'   => 1,
            'name' => 'Vehicles',
        ],
    ];

    $mockClient = new MockClient(mockData: [
        GetAllGroups::class => MockResponse::make(body: $payload),
    ]);

    $request = new GetAllGroups();
    $response = connector()->send(request: $request, mockClient: $mockClient);

    expect(value: $response->dto())
        ->toBeInstanceOf(class: Collection::class)
        ->and(value: $response->dto())->toHaveCount(1)
        ->and(value: $response->dto()->first())->toBeInstanceOf(class: GroupData::class);
});
