<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\TraccarConnector;
use ThingsTelemetry\Traccar\Requests\Position\DeleteDevicePositions;

beforeEach(closure: function () {
    $this->connector = new TraccarConnector(
        baseUrl: 'https://demo.traccar.org/api',
        apiKey: 'test-api-key'
    );
});

test(description: 'it resolves the correct endpoint', closure: function () {
    $from = CarbonImmutable::parse(time: '2026-11-22T18:30:00Z');
    $to = CarbonImmutable::parse(time: '2026-11-23T18:30:00Z');

    $request = new DeleteDevicePositions(deviceId: 6, from: $from, to: $to);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/positions')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'DELETE');
});

test(description: 'it sends the correct query parameters', closure: function () {
    $from = CarbonImmutable::parse(time: '2026-11-22T18:30:00Z');
    $to = CarbonImmutable::parse(time: '2026-11-23T18:30:00Z');

    $request = new DeleteDevicePositions(deviceId: 6, from: $from, to: $to);

    expect(value: $request->query()->get(key: 'deviceId'))->toBe(expected: 6)
        ->and(value: $request->query()->get(key: 'from'))->toBe(expected: $from->toIso8601String())
        ->and(value: $request->query()->get(key: 'to'))->toBe(expected: $to->toIso8601String());
});

test(description: 'it returns a success StatusData from response via createDtoFromResponse', closure: function () {
    $from = CarbonImmutable::parse(time: '2026-11-22T18:30:00Z');
    $to = CarbonImmutable::parse(time: '2026-11-23T18:30:00Z');

    $mockClient = new MockClient(mockData: [
        DeleteDevicePositions::class => MockResponse::make(body: '', status: 204),
    ]);

    $request = new DeleteDevicePositions(deviceId: 6, from: $from, to: $to);
    $response = $this->connector->send(request: $request, mockClient: $mockClient);

    $result = $response->dtoOrFail();

    expect(value: $result)->toBeInstanceOf(class: StatusData::class)
        ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
});
