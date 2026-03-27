<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\ServerStatisticsData;
use Saloon\Exceptions\Request\Statuses\NotFoundException;
use ThingsTelemetry\Traccar\Requests\Server\GetServerStatistics;

test(description: 'it can get server statistics', closure: function () {
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
        GetServerStatistics::class => MockResponse::make(body: $payload),
    ]);

    $request = new GetServerStatistics(from: $from, to: $to);
    $response = connector()->send(request: $request, mockClient: $mockClient);

    expect(value: $response->dto())
        ->toBeInstanceOf(class: ServerStatisticsData::class)
        ->and(value: $response->dto()->activeUsers)->toBe(2)
        ->and(value: $response->dto()->messagesStored)->toBe(440);
});

test(description: 'it throws NotFoundException for empty server statistics', closure: function () {
    $from = CarbonImmutable::parse(time: '2019-08-24T00:00:00Z');
    $to = CarbonImmutable::parse(time: '2019-08-25T00:00:00Z');

    $mockClient = new MockClient(mockData: [
        GetServerStatistics::class => MockResponse::make(body: [], status: 200),
    ]);

    $request = new GetServerStatistics(from: $from, to: $to);

    expect(value: fn () => connector()->send(request: $request, mockClient: $mockClient)->dto())
        ->toThrow(exception: NotFoundException::class, message: 'Statistics were not found. Check the date range and try again.');
});
