<?php

declare(strict_types=1);

use Saloon\Enums\Method;
use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Dto\MaintenanceData;
use ThingsTelemetry\Traccar\Facades\Maintenance;
use ThingsTelemetry\Traccar\Requests\Maintenance\CreateMaintenance;
use ThingsTelemetry\Traccar\Requests\Maintenance\DeleteMaintenance;
use ThingsTelemetry\Traccar\Requests\Maintenance\GetAllMaintenance;
use ThingsTelemetry\Traccar\Requests\Maintenance\UpdateMaintenance;

$getMaintenanceData = fn () => [
    'id'     => 11,
    'name'   => 'Oil Change',
    'type'   => 'distance',
    'start'  => 0,
    'period' => 10000,
];

describe(description: 'get all', tests: function () use ($getMaintenanceData) {
    test(description: 'request sends the correct query parameters', closure: function () {
        $request = new GetAllMaintenance(all: true, userId: 3, deviceId: 6, groupId: 4, refresh: true, limit: 10, offset: 2, keyword: 'oil');

        expect(value: $request->resolveEndpoint())->toBe(expected: '/maintenance')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET)
            ->and(value: $request->query()->all())->toBe(expected: [
                'all'      => true,
                'userId'   => 3,
                'deviceId' => 6,
                'groupId'  => 4,
                'refresh'  => true,
                'limit'    => 10,
                'offset'   => 2,
                'keyword'  => 'oil',
            ]);
    });

    test(description: 'returns all maintenance items', closure: function () use ($getMaintenanceData) {
        MockClient::global(mockData: [
            GetAllMaintenance::class => MockResponse::make([$getMaintenanceData()]),
        ]);

        $response = Maintenance::getAll();

        expect(value: $response)
            ->toBeInstanceOf(class: Collection::class)
            ->and(value: $response->first())->toBeInstanceOf(class: MaintenanceData::class);
    });
});

describe(description: 'create', tests: function () use ($getMaintenanceData) {
    test(description: 'request sends the correct body', closure: function () use ($getMaintenanceData) {
        $data = MaintenanceData::fromArray(data: $getMaintenanceData());
        $request = new CreateMaintenance(data: $data);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/maintenance')
            ->and(value: $request->getMethod())->toBe(expected: Method::POST)
            ->and(value: $request->body()->all())->toBe(expected: $data->toArray());
    });

    test(description: 'creates a maintenance item', closure: function () use ($getMaintenanceData) {
        MockClient::global(mockData: [
            CreateMaintenance::class => MockResponse::make($getMaintenanceData()),
        ]);

        $response = Maintenance::create(data: MaintenanceData::fromArray(data: $getMaintenanceData()));

        expect(value: $response)->toBeInstanceOf(class: MaintenanceData::class);
    });
});

describe(description: 'update', tests: function () use ($getMaintenanceData) {
    test(description: 'request sends the correct body', closure: function () use ($getMaintenanceData) {
        $data = MaintenanceData::fromArray(data: $getMaintenanceData());
        $request = new UpdateMaintenance(data: $data);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/maintenance/11')
            ->and(value: $request->getMethod())->toBe(expected: Method::PUT)
            ->and(value: $request->body()->all())->toBe(expected: $data->toArray());
    });

    test(description: 'updates a maintenance item', closure: function () use ($getMaintenanceData) {
        MockClient::global(mockData: [
            UpdateMaintenance::class => MockResponse::make($getMaintenanceData()),
        ]);

        $response = Maintenance::update(data: MaintenanceData::fromArray(data: $getMaintenanceData()));

        expect(value: $response)->toBeInstanceOf(class: MaintenanceData::class);
    });
});

describe(description: 'delete', tests: function () {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new DeleteMaintenance(id: 11);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/maintenance/11')
            ->and(value: $request->getMethod())->toBe(expected: Method::DELETE);
    });

    test(description: 'deletes a maintenance item', closure: function () {
        MockClient::global(mockData: [
            DeleteMaintenance::class => MockResponse::make(body: '', status: 204),
        ]);

        $result = Maintenance::delete(id: 11);

        expect(value: $result)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
    });
});
