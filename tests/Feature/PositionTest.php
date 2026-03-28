<?php

declare(strict_types=1);

use Saloon\Enums\Method;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Dto\PositionData;
use ThingsTelemetry\Traccar\Facades\Position;
use ThingsTelemetry\Traccar\Requests\Position\GetPositions;
use ThingsTelemetry\Traccar\Requests\Position\DeletePosition;
use ThingsTelemetry\Traccar\Requests\Position\GetPositionsCsv;
use ThingsTelemetry\Traccar\Requests\Position\GetPositionsGpx;
use ThingsTelemetry\Traccar\Requests\Position\GetPositionsKml;
use ThingsTelemetry\Traccar\Requests\Position\DeleteDevicePositions;

$getPositionData = fn () => [
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
    'network'     => ['cellTowers' => []],
    'geofenceIds' => [10, 11],
    'attributes'  => ['ignition' => true],
];

describe(description: 'all', tests: function () use ($getPositionData) {
    test(description: 'request sends the correct query parameters', closure: function () {
        $from = CarbonImmutable::parse(time: '2026-11-22T18:30:00Z');
        $to = CarbonImmutable::parse(time: '2026-11-23T18:30:00Z');
        $request = new GetPositions(deviceId: 6, from: $from, to: $to, geofenceId: 789, ids: [123, 456]);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/positions')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET)
            ->and(value: $request->query()->all())->toBe(expected: [
                'deviceId'   => 6,
                'from'       => $from->toIso8601String(),
                'to'         => $to->toIso8601String(),
                'geofenceId' => 789,
                'id'         => [123, 456],
            ]);
    });

    test(description: 'returns positions', closure: function () use ($getPositionData) {
        MockClient::global(mockData: [
            GetPositions::class => MockResponse::make([$getPositionData()]),
        ]);

        $positions = Position::all(geofenceId: 789, ids: [12345]);

        expect(value: $positions)
            ->toBeInstanceOf(class: Collection::class)
            ->and(value: $positions)->toHaveCount(count: 1)
            ->and(value: $positions->first())->toBeInstanceOf(class: PositionData::class)
            ->and(value: $positions->first()->id)->toBe(expected: 12345);
    });

    test(description: 'requires from and to together when filtering by time', closure: function () {
        $from = CarbonImmutable::parse(time: '2026-11-22T18:30:00Z');

        expect(value: fn () => Position::all(from: $from))
            ->toThrow(exception: \Illuminate\Validation\ValidationException::class);
    });

    test(description: 'requires from and to when device id is provided', closure: function () {
        expect(value: fn () => Position::all(deviceId: 6))
            ->toThrow(exception: \Illuminate\Validation\ValidationException::class);
    });
});

describe(description: 'delete', tests: function () {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new DeletePosition(id: 12345);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/positions/12345')
            ->and(value: $request->getMethod())->toBe(expected: Method::DELETE);
    });

    test(description: 'deletes a position', closure: function () {
        MockClient::global(mockData: [
            DeletePosition::class => MockResponse::make(body: '', status: 204),
        ]);

        $result = Position::delete(id: 12345);

        expect(value: $result)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
    });
});

describe(description: 'delete for device in range', tests: function () {
    test(description: 'request sends the correct query parameters', closure: function () {
        $from = CarbonImmutable::parse(time: '2026-11-22T18:30:00Z');
        $to = CarbonImmutable::parse(time: '2026-11-23T18:30:00Z');
        $request = new DeleteDevicePositions(deviceId: 6, from: $from, to: $to);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/positions')
            ->and(value: $request->getMethod())->toBe(expected: Method::DELETE)
            ->and(value: $request->query()->all())->toBe(expected: [
                'deviceId' => 6,
                'from'     => $from->toIso8601String(),
                'to'       => $to->toIso8601String(),
            ]);
    });

    test(description: 'deletes positions for a device in a time range', closure: function () {
        MockClient::global(mockData: [
            DeleteDevicePositions::class => MockResponse::make(body: '', status: 204),
        ]);

        $from = CarbonImmutable::parse(time: '2026-11-22T18:30:00Z');
        $to = CarbonImmutable::parse(time: '2026-11-23T18:30:00Z');

        $result = Position::deleteForDeviceInRange(deviceId: 6, from: $from, to: $to);

        expect(value: $result)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
    });
});

describe(description: 'export kml', tests: function () {
    test(description: 'request sends the correct query parameters and headers', closure: function () {
        $from = CarbonImmutable::parse(time: '2026-11-22T18:30:00Z');
        $to = CarbonImmutable::parse(time: '2026-11-23T18:30:00Z');
        $request = new GetPositionsKml(deviceId: 6, from: $from, to: $to);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/positions/kml')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET)
            ->and(value: $request->query()->all())->toBe(expected: [
                'deviceId' => 6,
                'from'     => $from->toIso8601String(),
                'to'       => $to->toIso8601String(),
            ])
            ->and(value: $request->headers()->get('Accept'))->toBe(expected: 'application/vnd.google-earth.kml+xml, */*');
    });

    test(description: 'exports positions as kml', closure: function () {
        MockClient::global(mockData: [
            GetPositionsKml::class => MockResponse::make(body: '<kml>demo</kml>'),
        ]);

        $from = CarbonImmutable::parse(time: '2026-11-22T18:30:00Z');
        $to = CarbonImmutable::parse(time: '2026-11-23T18:30:00Z');

        expect(value: Position::exportKml(deviceId: 6, from: $from, to: $to))
            ->toBe(expected: '<kml>demo</kml>');
    });
});

describe(description: 'export csv', tests: function () {
    test(description: 'request sends the correct query parameters and headers', closure: function () {
        $from = CarbonImmutable::parse(time: '2026-11-22T18:30:00Z');
        $to = CarbonImmutable::parse(time: '2026-11-23T18:30:00Z');
        $request = new GetPositionsCsv(deviceId: 6, from: $from, to: $to, geofenceId: 10);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/positions/csv')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET)
            ->and(value: $request->query()->all())->toBe(expected: [
                'deviceId'   => 6,
                'from'       => $from->toIso8601String(),
                'to'         => $to->toIso8601String(),
                'geofenceId' => 10,
            ])
            ->and(value: $request->headers()->get('Accept'))->toBe(expected: 'text/csv, */*');
    });

    test(description: 'exports positions as csv', closure: function () {
        MockClient::global(mockData: [
            GetPositionsCsv::class => MockResponse::make(body: "id,deviceId\n12345,6"),
        ]);

        $from = CarbonImmutable::parse(time: '2026-11-22T18:30:00Z');
        $to = CarbonImmutable::parse(time: '2026-11-23T18:30:00Z');

        expect(value: Position::exportCsv(deviceId: 6, from: $from, to: $to, geofenceId: 10))
            ->toBe(expected: "id,deviceId\n12345,6");
    });
});

describe(description: 'export gpx', tests: function () {
    test(description: 'request sends the correct query parameters and headers', closure: function () {
        $from = CarbonImmutable::parse(time: '2026-11-22T18:30:00Z');
        $to = CarbonImmutable::parse(time: '2026-11-23T18:30:00Z');
        $request = new GetPositionsGpx(deviceId: 6, from: $from, to: $to);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/positions/gpx')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET)
            ->and(value: $request->query()->all())->toBe(expected: [
                'deviceId' => 6,
                'from'     => $from->toIso8601String(),
                'to'       => $to->toIso8601String(),
            ])
            ->and(value: $request->headers()->get('Accept'))->toBe(expected: 'application/gpx+xml, */*');
    });

    test(description: 'exports positions as gpx', closure: function () {
        MockClient::global(mockData: [
            GetPositionsGpx::class => MockResponse::make(body: '<gpx>demo</gpx>'),
        ]);

        $from = CarbonImmutable::parse(time: '2026-11-22T18:30:00Z');
        $to = CarbonImmutable::parse(time: '2026-11-23T18:30:00Z');

        expect(value: Position::exportGpx(deviceId: 6, from: $from, to: $to))
            ->toBe(expected: '<gpx>demo</gpx>');
    });
});
