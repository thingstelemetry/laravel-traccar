<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\EventData;
use ThingsTelemetry\Traccar\Facades\Event;
use ThingsTelemetry\Traccar\Requests\GetEvent;

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
        ->and(value: $event->id)->toEqual(expected: 1234)
        ->and(value: $event->type)->toEqual(expected: 'geofenceEnter')
        ->and(value: $event->eventTime)->toBeInstanceOf(class: CarbonImmutable::class)
        ->and(value: $event->eventTime->toIso8601String())->toEqual(expected: '2019-08-24T14:15:22+00:00')
        ->and(value: $event->deviceId)->toEqual(expected: 42)
        ->and(value: $event->positionId)->toEqual(expected: 98765)
        ->and(value: $event->geofenceId)->toEqual(expected: 3)
        ->and(value: $event->maintenanceId)->toBeNull()
        ->and(value: $event->attributes)->toBeArray()
        ->and(value: $event->attributes['alarm'])->toEqual(expected: 'powerCut');
});
