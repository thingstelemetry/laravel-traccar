<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\TraccarConnector;
use ThingsTelemetry\Traccar\Dto\ServerStatisticsData;
use Saloon\Exceptions\Request\Statuses\NotFoundException;
use ThingsTelemetry\Traccar\Requests\Server\GetServerStatistics;

beforeEach(closure: function () {
    $this->connector = new TraccarConnector(
        baseUrl: 'https://demo.traccar.org/api',
        apiKey: 'test-api-key'
    );
});

test(description: 'it resolves the correct endpoint', closure: function () {
    $from = CarbonImmutable::parse(time: '2019-08-24T00:00:00Z');
    $to = CarbonImmutable::parse(time: '2019-08-25T00:00:00Z');

    $request = new GetServerStatistics(from: $from, to: $to);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/statistics')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'GET');
});

test(description: 'it sends the correct query parameters', closure: function () {
    $from = CarbonImmutable::parse(time: '2019-08-24T00:00:00Z');
    $to = CarbonImmutable::parse(time: '2019-08-25T00:00:00Z');

    $request = new GetServerStatistics(from: $from, to: $to);

    expect(value: $request->query()->get(key: 'from'))->toBe(expected: $from->toIso8601String())
        ->and(value: $request->query()->get(key: 'to'))->toBe(expected: $to->toIso8601String());
});

test(description: 'it creates a ServerStatisticsData DTO from response via createDtoFromResponse', closure: function () {
    $payload = [
        [
            'captureTime'      => '2019-08-24T14:15:22Z',
            'activeUsers'      => 2,
            'activeDevices'    => 5,
            'requests'         => 120,
            'messagesReceived' => 450,
            'messagesStored'   => 440,
        ],
    ];

    $from = CarbonImmutable::parse(time: '2019-08-24T00:00:00Z');
    $to = CarbonImmutable::parse(time: '2019-08-25T00:00:00Z');

    $mockClient = new MockClient(mockData: [
        GetServerStatistics::class => MockResponse::make(body: $payload, status: 200),
    ]);

    $request = new GetServerStatistics(from: $from, to: $to);
    $response = $this->connector->send(request: $request, mockClient: $mockClient);

    $stats = $response->dtoOrFail();

    expect(value: $stats)->toBeInstanceOf(class: ServerStatisticsData::class)
        ->and(value: $stats->activeUsers)->toBe(expected: 2)
        ->and(value: $stats->messagesStored)->toBe(expected: 440);
});

test(description: 'it throws NotFoundException for empty server statistics via createDtoFromResponse', closure: function () {
    $from = CarbonImmutable::parse(time: '2019-08-24T00:00:00Z');
    $to = CarbonImmutable::parse(time: '2019-08-25T00:00:00Z');

    $mockClient = new MockClient(mockData: [
        GetServerStatistics::class => MockResponse::make(body: [], status: 200),
    ]);

    $request = new GetServerStatistics(from: $from, to: $to);

    expect(value: fn () => $this->connector->send(request: $request, mockClient: $mockClient)->dtoOrFail())
        ->toThrow(exception: NotFoundException::class, exceptionMessage: 'Statistics were not found. Check the date range and try again.');
});
