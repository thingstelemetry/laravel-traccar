<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\TraccarConnector;
use ThingsTelemetry\Traccar\Dto\PermissionData;
use ThingsTelemetry\Traccar\Requests\Permission\UnlinkPermission;

beforeEach(closure: function () {
    $this->connector = new TraccarConnector(
        baseUrl: 'https://demo.traccar.org/api',
        apiKey: 'test-api-key'
    );
});

test(description: 'it resolves the correct endpoint', closure: function () {
    $data = new PermissionData(userId: 1, deviceId: 6);
    $request = new UnlinkPermission(data: $data);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/permissions')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'DELETE');
});

test(description: 'it sends the correct body', closure: function () {
    $data = new PermissionData(userId: 1, deviceId: 6);
    $request = new UnlinkPermission(data: $data);

    expect(value: $request->body()->all())->toBe(expected: [
        'userId'   => 1,
        'deviceId' => 6,
    ]);
});

test(description: 'it returns a success StatusData from response via createDtoFromResponse', closure: function () {
    $data = new PermissionData(userId: 1, deviceId: 6);

    $mockClient = new MockClient(mockData: [
        UnlinkPermission::class => MockResponse::make(body: '', status: 204),
    ]);

    $request = new UnlinkPermission(data: $data);
    $response = $this->connector->send(request: $request, mockClient: $mockClient);

    $result = $response->dtoOrFail();

    expect(value: $result)->toBeInstanceOf(class: StatusData::class)
        ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
});
