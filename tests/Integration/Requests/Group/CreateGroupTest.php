<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\Group;

use ThingsTelemetry\Traccar\Dto\GroupData;
use ThingsTelemetry\Traccar\Requests\Group\CreateGroup;

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

    expect(value: $request->body()->all())->toBe(expected: $data->toArray());
});
