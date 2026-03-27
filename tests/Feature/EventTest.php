<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\EventData;
use ThingsTelemetry\Traccar\Facades\Event;
use ThingsTelemetry\Traccar\Requests\Event\GetEvent;

it(description: 'can retrieve an event by id', closure: function () {
    $payload = [
        'id'            => 1234,
        'type'          => 'geofenceEnter',
        'eventTime'     => '2019-08-24T14:15:22Z',
        'deviceId'      => 42,
        'positionId'    => 98765,
        'geofenceId'    => 3,
        'maintenanceId' => null,
        'attributes'    => [
            'alarm' => 'powerCut',
            'speed' => 32.1,
        ],
    ];

    MockClient::global(mockData: [
        GetEvent::class => MockResponse::make($payload),
    ]);

    $event = Event::get(id: 1234);

    expect(value: $event)
        ->toBeInstanceOf(class: EventData::class)
        ->and(value: $event->id)->toEqual(expected: 1234);
});
