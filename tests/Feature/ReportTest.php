<?php

declare(strict_types=1);

use Saloon\Enums\Method;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\EventData;
use ThingsTelemetry\Traccar\Facades\Report;
use ThingsTelemetry\Traccar\Dto\PositionData;
use Illuminate\Validation\ValidationException;
use ThingsTelemetry\Traccar\Dto\ReportStopsData;
use ThingsTelemetry\Traccar\Dto\ReportTripsData;
use ThingsTelemetry\Traccar\Dto\ReportSummaryData;
use ThingsTelemetry\Traccar\Dto\ReportGeofencesData;
use ThingsTelemetry\Traccar\Requests\Report\GetRouteReport;
use ThingsTelemetry\Traccar\Requests\Report\GetStopsReport;
use ThingsTelemetry\Traccar\Requests\Report\GetTripsReport;
use ThingsTelemetry\Traccar\Requests\Report\GetEventsReport;
use ThingsTelemetry\Traccar\Requests\Report\GetSummaryReport;
use ThingsTelemetry\Traccar\Requests\Report\GetGeofencesReport;

$from = CarbonImmutable::parse(time: '2026-11-22T18:30:00Z');
$to = CarbonImmutable::parse(time: '2026-11-23T18:30:00Z');

$positionPayload = fn () => [[
    'id'          => 12345,
    'deviceId'    => 6,
    'protocol'    => 'osmand',
    'deviceTime'  => '2026-11-22T18:30:00Z',
    'fixTime'     => '2026-11-22T18:30:00Z',
    'serverTime'  => '2026-11-22T18:31:00Z',
    'valid'       => true,
    'latitude'    => -1.286389,
    'longitude'   => 36.817223,
    'altitude'    => 1795.4,
    'speed'       => 18.2,
    'course'      => 145.0,
    'address'     => 'Nairobi, Kenya',
    'accuracy'    => 12.5,
    'network'     => [],
    'geofenceIds' => [],
    'attributes'  => [],
]];

$eventPayload = fn () => [[
    'id'         => 55,
    'type'       => 'ignitionOn',
    'eventTime'  => '2026-11-22T18:30:00Z',
    'deviceId'   => 6,
    'attributes' => [],
]];

$reportGeofencePayload = fn () => [[
    'deviceId'   => 6,
    'deviceName' => 'Truck 1',
    'geofenceId' => 15,
    'startTime'  => '2026-11-22T18:30:00Z',
    'endTime'    => '2026-11-22T19:30:00Z',
]];

$reportSummaryPayload = fn () => [[
    'deviceId'     => 6,
    'deviceName'   => 'Truck 1',
    'maxSpeed'     => 80.0,
    'averageSpeed' => 45.0,
    'distance'     => 10000.0,
    'spentFuel'    => 5.5,
    'engineHours'  => 3600,
]];

$reportTripsPayload = fn () => [[
    'deviceId'       => 6,
    'deviceName'     => 'Truck 1',
    'maxSpeed'       => 80.0,
    'averageSpeed'   => 45.0,
    'distance'       => 10000.0,
    'spentFuel'      => 5.5,
    'duration'       => 3600,
    'startTime'      => '2026-11-22T18:30:00Z',
    'startAddress'   => 'A',
    'startLat'       => 1.0,
    'startLon'       => 2.0,
    'endTime'        => '2026-11-22T19:30:00Z',
    'endAddress'     => 'B',
    'endLat'         => 3.0,
    'endLon'         => 4.0,
    'driverUniqueId' => 'DRV-001',
    'driverName'     => 'John Doe',
]];

$reportStopsPayload = fn () => [[
    'deviceId'    => 6,
    'deviceName'  => 'Truck 1',
    'duration'    => 1800,
    'startTime'   => '2026-11-22T18:30:00Z',
    'address'     => 'Stop A',
    'lat'         => 1.0,
    'lon'         => 2.0,
    'endTime'     => '2026-11-22T19:00:00Z',
    'spentFuel'   => 1.0,
    'engineHours' => 1200,
]];

describe(description: 'request serialization', tests: function () use ($from, $to) {
    test(description: 'serializes route report queries', closure: function () use ($from, $to) {
        $request = new GetRouteReport(deviceIds: [6, 7], groupIds: [4], from: $from, to: $to);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/reports/route')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET)
            ->and(value: $request->query()->all())->toBe(expected: [
                'deviceId' => [6, 7],
                'groupId'  => [4],
                'from'     => $from->toIso8601String(),
                'to'       => $to->toIso8601String(),
            ]);
    });

    test(description: 'serializes event and geofence report queries', closure: function () use ($from, $to) {
        $events = new GetEventsReport(deviceIds: [6], groupIds: [4], from: $from, to: $to, types: ['ignitionOn', '%']);
        $geofences = new GetGeofencesReport(deviceIds: [6], groupIds: [], from: $from, to: $to, geofenceIds: [15, 16]);

        expect(value: $events->query()->all())->toBe(expected: [
            'deviceId' => [6],
            'groupId'  => [4],
            'type'     => ['ignitionOn', '%'],
            'from'     => $from->toIso8601String(),
            'to'       => $to->toIso8601String(),
        ])->and(value: $geofences->query()->all())->toBe(expected: [
            'deviceId'   => [6],
            'geofenceId' => [15, 16],
            'from'       => $from->toIso8601String(),
            'to'         => $to->toIso8601String(),
        ]);
    });
});

describe(description: 'report results', tests: function () use ($from, $to, $positionPayload, $eventPayload, $reportGeofencePayload, $reportSummaryPayload, $reportTripsPayload, $reportStopsPayload) {
    test(description: 'hydrates all report collections', closure: function () use ($from, $to, $positionPayload, $eventPayload, $reportGeofencePayload, $reportSummaryPayload, $reportTripsPayload, $reportStopsPayload) {
        MockClient::global(mockData: [
            GetRouteReport::class     => MockResponse::make($positionPayload()),
            GetEventsReport::class    => MockResponse::make($eventPayload()),
            GetGeofencesReport::class => MockResponse::make($reportGeofencePayload()),
            GetSummaryReport::class   => MockResponse::make($reportSummaryPayload()),
            GetTripsReport::class     => MockResponse::make($reportTripsPayload()),
            GetStopsReport::class     => MockResponse::make($reportStopsPayload()),
        ]);

        expect(value: Report::route(deviceIds: [6], groupIds: [], from: $from, to: $to))->toBeInstanceOf(class: Collection::class)
            ->and(value: Report::route(deviceIds: [6], groupIds: [], from: $from, to: $to)->first())->toBeInstanceOf(class: PositionData::class)
            ->and(value: Report::events(deviceIds: [6], groupIds: [], from: $from, to: $to)->first())->toBeInstanceOf(class: EventData::class)
            ->and(value: Report::geofences(deviceIds: [6], groupIds: [], from: $from, to: $to)->first())->toBeInstanceOf(class: ReportGeofencesData::class)
            ->and(value: Report::summary(deviceIds: [6], groupIds: [], from: $from, to: $to)->first())->toBeInstanceOf(class: ReportSummaryData::class)
            ->and(value: Report::trips(deviceIds: [6], groupIds: [], from: $from, to: $to)->first())->toBeInstanceOf(class: ReportTripsData::class)
            ->and(value: Report::stops(deviceIds: [6], groupIds: [], from: $from, to: $to)->first())->toBeInstanceOf(class: ReportStopsData::class);
    });
});

describe(description: 'validation', tests: function () use ($from, $to) {
    test(description: 'requires at least one device or group id', closure: function () use ($from, $to) {
        expect(value: fn () => Report::route(deviceIds: [], groupIds: [], from: $from, to: $to))
            ->toThrow(exception: ValidationException::class);
    });

    test(description: 'requires a valid time range', closure: function () use ($from) {
        expect(value: fn () => Report::summary(deviceIds: [6], groupIds: [], from: $from, to: $from))
            ->toThrow(exception: ValidationException::class);
    });
});
