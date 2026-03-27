<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\EventData;
use ThingsTelemetry\Traccar\Requests\Event\GetEvent;

test(description: 'it can get an event by id', closure: function () {
    $body = [
        'id'          => 1,
        'type'        => 'deviceOnline',
        'eventTime'   => '2019-08-24T14:15:22Z',
        'deviceId'    => 6,
        'positionId'  => 123,
        'geofenceId'  => 0,
        'maintenanceId'=> 0,
        'attributes'  => [],
    ];

    $mockClient = new MockClient(mockData: [
        GetEvent::class => MockResponse::make(body: $body),
    ]);

    $request = new GetEvent(id: 1);
    $response = connector()->send(request: $request, mockClient: $mockClient);

    expect(value: $response->dto())
        ->toBeInstanceOf(class: EventData::class)
        ->and(value: $response->dto()->id)->toBe(1)
        ->and(value: $response->dto()->type)->toBe('deviceOnline')
        ->and(value: $response->dto()->eventTime)->toBeInstanceOf(class: CarbonImmutable::class);
});
