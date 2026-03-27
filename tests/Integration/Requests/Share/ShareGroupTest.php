<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\GroupShareData;
use ThingsTelemetry\Traccar\Requests\Share\ShareGroup;

test(description: 'it can share a group', closure: function () {
    $mockClient = new MockClient(mockData: [
        ShareGroup::class => MockResponse::make(body: 'token-abc-123'),
    ]);

    $expiration = CarbonImmutable::parse(time: '2030-12-31T23:59:59Z');
    $request = new ShareGroup(groupId: 6, expiration: $expiration);
    $response = connector()->send(request: $request, mockClient: $mockClient);

    expect(value: $response->dto())
        ->toBeInstanceOf(class: GroupShareData::class)
        ->and(value: $response->dto()->token)->toBe(expected: 'token-abc-123')
        ->and(value: $response->dto()->groupId)->toBe(6);
});
