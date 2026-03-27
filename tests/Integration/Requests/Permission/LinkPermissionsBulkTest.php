<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\TraccarConnector;
use ThingsTelemetry\Traccar\Dto\PermissionData;
use ThingsTelemetry\Traccar\Requests\Permission\LinkPermissionsBulk;

beforeEach(closure: function () {
    $this->connector = new TraccarConnector(
        baseUrl: 'https://demo.traccar.org/api',
        apiKey: 'test-api-key'
    );
});

test(description: 'it resolves the correct endpoint', closure: function () {
    $permissions = [new PermissionData(userId: 1, deviceId: 5)];
    $request = new LinkPermissionsBulk(permissions: $permissions);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/permissions')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'POST');
});

test(description: 'it sends the correct body', closure: function () {
    $permissions = [
        new PermissionData(userId: 1, deviceId: 5),
        new PermissionData(userId: 1, deviceId: 6),
    ];
    $request = new LinkPermissionsBulk(permissions: $permissions);

    expect(value: $request->body()->all())->toBe(expected: [
        ['userId' => 1, 'deviceId' => 5],
        ['userId' => 1, 'deviceId' => 6],
    ]);
});

test(description: 'it returns a success StatusData from response via createDtoFromResponse', closure: function () {
    $permissions = [new PermissionData(userId: 1, deviceId: 5)];

    $mockClient = new MockClient(mockData: [
        LinkPermissionsBulk::class => MockResponse::make(body: '', status: 204),
    ]);

    $request = new LinkPermissionsBulk(permissions: $permissions);
    $response = $this->connector->send(request: $request, mockClient: $mockClient);

    $result = $response->dtoOrFail();

    expect(value: $result)->toBeInstanceOf(class: StatusData::class)
        ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
});
