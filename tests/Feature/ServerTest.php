<?php

declare(strict_types=1);

use Saloon\Enums\Method;
use Carbon\CarbonImmutable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\ServerData;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Facades\Server;
use ThingsTelemetry\Traccar\Dto\ServerStatisticsData;
use Saloon\Exceptions\Request\Statuses\NotFoundException;
use ThingsTelemetry\Traccar\Requests\Server\RebootServer;
use ThingsTelemetry\Traccar\Requests\Server\GetServerCache;
use ThingsTelemetry\Traccar\Requests\Server\ReverseGeocode;
use ThingsTelemetry\Traccar\Requests\Server\UploadServerFile;
use ThingsTelemetry\Traccar\Requests\Server\GetServerTimezones;
use ThingsTelemetry\Traccar\Requests\Server\GetServerStatistics;
use ThingsTelemetry\Traccar\Requests\Server\RunGarbageCollector;
use ThingsTelemetry\Traccar\Requests\Server\GetServerInformation;
use ThingsTelemetry\Traccar\Requests\Server\UpdateServerInformation;

$getServerData = fn () => [
    "id"              => 1,
    "version"         => "6.10.0",
    "registration"    => false,
    "readonly"        => false,
    "deviceReadonly"  => false,
    "latitude"        => 0.0,
    "longitude"       => 0.0,
    "zoom"            => 0,
    "forceSettings"   => false,
    "limitCommands"   => false,
    "disableReports"  => false,
    "fixedEmail"      => false,
    "emailEnabled"    => false,
    "geocoderEnabled" => false,
    "textEnabled"     => false,
    "newServer"       => false,
    "openIdEnabled"   => false,
    "openIdForce"     => false,
    "attributes"      => [],
    "storageSpace"    => [0, 0, 0, 0],
];

describe(description: 'get information', tests: function () use ($getServerData) {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new GetServerInformation();

        expect(value: $request->resolveEndpoint())->toBe(expected: '/server')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET);
    });

    test(description: 'returns server information', closure: function () use ($getServerData) {
        MockClient::global(mockData: [
            GetServerInformation::class => MockResponse::make(body: $getServerData())
        ]);

        $response = Server::getInformation();

        expect(value: $response)
            ->toBeInstanceOf(class: ServerData::class);
    });
});

describe(description: 'update information', tests: function () use ($getServerData) {
    test(description: 'request sends the correct body', closure: function () use ($getServerData) {
        $data = ServerData::fromArray(data: $getServerData());
        $request = new UpdateServerInformation(data: $data);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/server')
            ->and(value: $request->getMethod())->toBe(expected: Method::PUT)
            ->and(value: $request->body()->all())->toBe(expected: $data->toArray());
    });

    test(description: 'updates server information', closure: function () use ($getServerData) {
        MockClient::global(mockData: [
            UpdateServerInformation::class => MockResponse::make(body: $getServerData())
        ]);

        $response = Server::updateInformation(ServerData::fromArray(data: $getServerData()));

        expect(value: $response)
            ->toBeInstanceOf(class: ServerData::class);
    });
});

describe(description: 'reboot', tests: function () {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new RebootServer();

        expect(value: $request->resolveEndpoint())->toBe(expected: '/server/reboot')
            ->and(value: $request->getMethod())->toBe(expected: Method::POST);
    });

    test(description: 'reboots the server', closure: function () {
        MockClient::global(mockData: [
            RebootServer::class => MockResponse::make(body: '', status: 204)
        ]);

        $result = Server::reboot();

        expect(value: $result)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
    });
});

describe(description: 'cache', tests: function () {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new GetServerCache();

        expect(value: $request->resolveEndpoint())->toBe(expected: '/server/cache')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET);
    });

    test(description: 'returns the server cache string', closure: function () {
        MockClient::global(mockData: [
            GetServerCache::class => MockResponse::make(body: 'Cache{devices=123, users=45}')
        ]);

        $cache = Server::cache();

        expect(value: $cache)
            ->toBeString()
            ->toContain('Cache{');
    });
});

describe(description: 'gc', tests: function () {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new RunGarbageCollector();

        expect(value: $request->resolveEndpoint())->toBe(expected: '/server/gc')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET);
    });

    test(description: 'triggers the garbage collector', closure: function () {
        MockClient::global(mockData: [
            RunGarbageCollector::class => MockResponse::make(body: '', status: 204)
        ]);

        $result = Server::gc();

        expect(value: $result)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
    });
});

describe(description: 'upload file', tests: function () {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new UploadServerFile(path: 'web/readme.txt', mimeType: 'text/plain', contents: 'hello');

        expect(value: $request->resolveEndpoint())->toBe(expected: '/server/file/web/readme.txt')
            ->and(value: $request->getMethod())->toBe(expected: Method::POST);
    });

    test(description: 'uploads a file to the server path', closure: function () {
        MockClient::global(mockData: [
            UploadServerFile::class => MockResponse::make(body: '', status: 200)
        ]);

        $uploaded = UploadedFile::fake()->create(name: 'readme.txt', kilobytes: 1, mimeType: 'text/plain');

        $result = Server::uploadFile(path: 'web/readme.txt', file: $uploaded);

        expect(value: $result)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
    });
});

describe(description: 'timezones', tests: function () {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new GetServerTimezones();

        expect(value: $request->resolveEndpoint())->toBe(expected: '/server/timezones')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET);
    });

    test(description: 'returns the server timezones', closure: function () {
        MockClient::global(mockData: [
            GetServerTimezones::class => MockResponse::make(body: ['UTC', 'Africa/Nairobi'])
        ]);

        $zones = Server::timezones();

        expect(value: $zones)
            ->toBeInstanceOf(class: Collection::class)
            ->and(value: $zones)->toHaveCount(count: 2);
    });
});

describe(description: 'geocode', tests: function () {
    test(description: 'request sends the correct query parameters', closure: function () {
        $request = new ReverseGeocode(latitude: -1.286389, longitude: 36.817223);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/server/geocode')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET)
            ->and(value: $request->query()->all())->toBe(expected: [
                'latitude'  => -1.286389,
                'longitude' => 36.817223,
            ]);
    });

    test(description: 'reverse geocodes coordinates', closure: function () {
        MockClient::global(mockData: [
            ReverseGeocode::class => MockResponse::make(body: 'Nairobi, Kenya')
        ]);

        $address = Server::geocode(latitude: -1.286389, longitude: 36.817223);

        expect(value: $address)
            ->toBeString()
            ->toBe(expected: 'Nairobi, Kenya');
    });
});

describe(description: 'statistics', tests: function () {
    test(description: 'request sends the correct query parameters', closure: function () {
        $from = CarbonImmutable::parse(time: '2019-08-24T00:00:00Z');
        $to = CarbonImmutable::parse(time: '2019-08-25T00:00:00Z');
        $request = new GetServerStatistics(from: $from, to: $to);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/statistics')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET)
            ->and(value: $request->query()->all())->toBe(expected: [
                'from' => $from->toIso8601String(),
                'to'   => $to->toIso8601String(),
            ]);
    });

    test(description: 'returns server statistics for a date range', closure: function () {
        $payload = [
            [
                'captureTime' => '2019-08-24T14:15:22Z',
                'requests'    => 120,
            ],
        ];

        MockClient::global(mockData: [
            GetServerStatistics::class => MockResponse::make(body: $payload),
        ]);

        $from = CarbonImmutable::parse(time: '2019-08-24T00:00:00Z');
        $to = CarbonImmutable::parse(time: '2019-08-25T00:00:00Z');

        $stats = Server::statistics(from: $from, to: $to);

        expect(value: $stats)
            ->toBeInstanceOf(class: ServerStatisticsData::class);
    });

    test(description: 'throws not found when the statistics response is empty', closure: function () {
        MockClient::global(mockData: [
            GetServerStatistics::class => MockResponse::make(body: [], status: 200),
        ]);

        $from = CarbonImmutable::parse(time: '2019-08-24T00:00:00Z');
        $to = CarbonImmutable::parse(time: '2019-08-25T00:00:00Z');

        expect(value: fn () => Server::statistics(from: $from, to: $to))
            ->toThrow(exception: NotFoundException::class, exceptionMessage: 'Statistics were not found. Check the date range and try again.');
    });
});
