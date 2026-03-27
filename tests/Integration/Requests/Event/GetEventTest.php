<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\EventData;
use ThingsTelemetry\Traccar\TraccarConnector;
use ThingsTelemetry\Traccar\Requests\Event\GetEvent;

beforeEach(closure: function () {
    $this->connector = new TraccarConnector(
        baseUrl: 'https://demo.traccar.org/api',
        apiKey: 'test-api-key'
    );
});

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new GetEvent(id: 1);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/events/1')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'GET');
});

test(description: 'it creates an EventData DTO from response via createDtoFromResponse', closure: function () {
    $body = [
        'id'            => 1,
        'type'          => 'deviceOnline',
        'eventTime'     => '2019-08-24T14:15:22Z',
        'deviceId'      => 6,
        'positionId'    => 123,
        'geofenceId'    => 0,
        'maintenanceId' => 0,
        'attributes'    => [],
    ];

    $mockClient = new MockClient(mockData: [
        GetEvent::class => MockResponse::make(body: $body, status: 200),
    ]);

    $request = new GetEvent(id: 1);
    $response = $this->connector->send(request: $request, mockClient: $mockClient);

    $event = $response->dtoOrFail();

    expect(value: $event)->toBeInstanceOf(class: EventData::class)
        ->and(value: $event->id)->toBe(expected: 1)
        ->and(value: $event->type)->toBe(expected: 'deviceOnline')
        ->and(value: $event->eventTime)->toBeInstanceOf(class: CarbonImmutable::class);
});
