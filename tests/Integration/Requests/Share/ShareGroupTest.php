<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\TraccarConnector;
use ThingsTelemetry\Traccar\Dto\GroupShareData;
use ThingsTelemetry\Traccar\Requests\Share\ShareGroup;

beforeEach(closure: function () {
    $this->connector = new TraccarConnector(
        baseUrl: 'https://demo.traccar.org/api',
        apiKey: 'test-api-key'
    );
});

test(description: 'it resolves the correct endpoint', closure: function () {
    $expiration = CarbonImmutable::parse('2030-12-31T23:59:59Z');
    $request = new ShareGroup(groupId: 6, expiration: $expiration);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/groups/6/share')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'GET');
});

test(description: 'it sends the correct query parameters', closure: function () {
    $expiration = CarbonImmutable::parse('2030-12-31T23:59:59Z');
    $request = new ShareGroup(groupId: 6, expiration: $expiration);

    expect(value: $request->query()->get(key: 'expiration'))->toBe(expected: $expiration->toIso8601String());
});

test(description: 'it creates a GroupShareData DTO from response via createDtoFromResponse', closure: function () {
    $groupId = 6;
    $token = 'token-abc-123';
    $expiration = CarbonImmutable::parse('2030-12-31T23:59:59Z');

    $mockClient = new MockClient(mockData: [
        ShareGroup::class => MockResponse::make(body: $token, status: 200),
    ]);

    $request = new ShareGroup(groupId: $groupId, expiration: $expiration);
    $response = $this->connector->send(request: $request, mockClient: $mockClient);

    $share = $response->dtoOrFail();

    expect(value: $share)->toBeInstanceOf(class: GroupShareData::class)
        ->and(value: $share->groupId)->toBe(expected: $groupId)
        ->and(value: $share->token)->toBe(expected: $token);
});
