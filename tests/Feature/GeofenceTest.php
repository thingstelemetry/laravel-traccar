<?php

declare(strict_types=1);

use Saloon\Enums\Method;
use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Dto\GeofenceData;
use ThingsTelemetry\Traccar\Facades\Geofence;
use ThingsTelemetry\Traccar\Requests\Geofence\CreateGeofence;
use ThingsTelemetry\Traccar\Requests\Geofence\DeleteGeofence;
use ThingsTelemetry\Traccar\Requests\Geofence\UpdateGeofence;
use ThingsTelemetry\Traccar\Requests\Geofence\GetAllGeofences;

$getGeofenceData = fn () => [
    'id'          => 15,
    'name'        => 'Warehouse',
    'description' => 'Main depot',
    'area'        => 'POLYGON ((36.8 -1.2, 36.9 -1.2, 36.9 -1.3, 36.8 -1.3, 36.8 -1.2))',
];

describe(description: 'get all', tests: function () use ($getGeofenceData) {
    test(description: 'request sends the correct query parameters', closure: function () {
        $request = new GetAllGeofences(all: true, userId: 3, deviceId: 6, groupId: 4, refresh: true, limit: 10, offset: 2, keyword: 'warehouse');

        expect(value: $request->resolveEndpoint())->toBe(expected: '/geofences')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET)
            ->and(value: $request->query()->all())->toBe(expected: [
                'all'      => true,
                'userId'   => 3,
                'deviceId' => 6,
                'groupId'  => 4,
                'refresh'  => true,
                'limit'    => 10,
                'offset'   => 2,
                'keyword'  => 'warehouse',
            ]);
    });

    test(description: 'returns all geofences', closure: function () use ($getGeofenceData) {
        MockClient::global(mockData: [
            GetAllGeofences::class => MockResponse::make([$getGeofenceData()]),
        ]);

        $response = Geofence::getAll();

        expect(value: $response)
            ->toBeInstanceOf(class: Collection::class)
            ->and(value: $response->first())->toBeInstanceOf(class: GeofenceData::class);
    });
});

describe(description: 'create', tests: function () use ($getGeofenceData) {
    test(description: 'request sends the correct body', closure: function () use ($getGeofenceData) {
        $data = GeofenceData::fromArray(data: $getGeofenceData());
        $request = new CreateGeofence(data: $data);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/geofences')
            ->and(value: $request->getMethod())->toBe(expected: Method::POST)
            ->and(value: $request->body()->all())->toBe(expected: $data->toArray());
    });

    test(description: 'creates a geofence', closure: function () use ($getGeofenceData) {
        MockClient::global(mockData: [
            CreateGeofence::class => MockResponse::make($getGeofenceData()),
        ]);

        $response = Geofence::create(data: GeofenceData::fromArray(data: $getGeofenceData()));

        expect(value: $response)->toBeInstanceOf(class: GeofenceData::class);
    });
});

describe(description: 'update', tests: function () use ($getGeofenceData) {
    test(description: 'request sends the correct body', closure: function () use ($getGeofenceData) {
        $data = GeofenceData::fromArray(data: $getGeofenceData());
        $request = new UpdateGeofence(data: $data);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/geofences/15')
            ->and(value: $request->getMethod())->toBe(expected: Method::PUT)
            ->and(value: $request->body()->all())->toBe(expected: $data->toArray());
    });

    test(description: 'updates a geofence', closure: function () use ($getGeofenceData) {
        MockClient::global(mockData: [
            UpdateGeofence::class => MockResponse::make($getGeofenceData()),
        ]);

        $response = Geofence::update(data: GeofenceData::fromArray(data: $getGeofenceData()));

        expect(value: $response)->toBeInstanceOf(class: GeofenceData::class);
    });
});

describe(description: 'delete', tests: function () {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new DeleteGeofence(id: 15);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/geofences/15')
            ->and(value: $request->getMethod())->toBe(expected: Method::DELETE);
    });

    test(description: 'deletes a geofence', closure: function () {
        MockClient::global(mockData: [
            DeleteGeofence::class => MockResponse::make(body: '', status: 204),
        ]);

        $result = Geofence::delete(id: 15);

        expect(value: $result)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
    });
});
