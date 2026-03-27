<?php

declare(strict_types=1);

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
    "id"               => 1,
    "version"          => "6.10.0",
    "registration"     => false,
    "readonly"         => false,
    "deviceReadonly"   => false,
    "latitude"         => 0.0,
    "longitude"        => 0.0,
    "zoom"             => 0,
    "forceSettings"    => false,
    "limitCommands"    => false,
    "disableReports"   => false,
    "fixedEmail"       => false,
    "emailEnabled"     => false,
    "geocoderEnabled"  => false,
    "textEnabled"      => false,
    "newServer"        => false,
    "openIdEnabled"    => false,
    "openIdForce"      => false,
    "attributes"       => [],
    "storageSpace"     => [0, 0, 0, 0],
];

test(description: 'can get server information', closure: function () use ($getServerData) {
    MockClient::global(mockData: [
        GetServerInformation::class => MockResponse::make(body: $getServerData())
    ]);

    $response = Server::getInformation();

    expect(value: $response)
        ->toBeInstanceOf(class: ServerData::class);
});

test(description: 'can update server information', closure: function () use ($getServerData) {
    MockClient::global(mockData: [
        UpdateServerInformation::class => MockResponse::make(body: $getServerData())
    ]);

    $response = Server::updateInformation(ServerData::fromArray(data: $getServerData()));

    expect(value: $response)
        ->toBeInstanceOf(class: ServerData::class);
});

test(description: 'can reboot server', closure: function () {
    MockClient::global(mockData: [
        RebootServer::class => MockResponse::make(body: '', status: 204)
    ]);

    $result = Server::reboot();

    expect(value: $result)
        ->toBeInstanceOf(class: StatusData::class)
        ->and(value: $result->status)->toEqual(expected: Status::SUCCESS);
});

test(description: 'can fetch server cache string', closure: function () {
    MockClient::global(mockData: [
        GetServerCache::class => MockResponse::make('Cache{devices=123, users=45}')
    ]);

    $cache = Server::cache();

    expect(value: $cache)
        ->toBeString()
        ->toContain('Cache{');
});

test(description: 'can trigger garbage collector', closure: function () {
    MockClient::global(mockData: [
        RunGarbageCollector::class => MockResponse::make('', 204)
    ]);

    $result = Server::gc();

    expect(value: $result)
        ->toBeInstanceOf(class: StatusData::class)
        ->and(value: $result->status)->toEqual(expected: Status::SUCCESS);
});

test(description: 'can upload a file to server path', closure: function () {
    MockClient::global(mockData: [
        UploadServerFile::class => MockResponse::make('', 200)
    ]);

    $uploaded = UploadedFile::fake()->create(name: 'readme.txt', kilobytes: 1, mimeType: 'text/plain');

    $result = Server::uploadFile(path: 'web/readme.txt', file: $uploaded);

    expect(value: $result)
        ->toBeInstanceOf(class: StatusData::class)
        ->and(value: $result->status)->toEqual(expected: Status::SUCCESS);
});

test(description: 'can get server timezones', closure: function () {
    MockClient::global(mockData: [
        GetServerTimezones::class => MockResponse::make(['UTC', 'Africa/Nairobi'])
    ]);

    $zones = Server::timezones();

    expect(value: $zones)
        ->toBeInstanceOf(class: Collection::class)
        ->and(value: $zones)->toHaveCount(count: 2);
});

test(description: 'can reverse geocode coordinates', closure: function () {
    MockClient::global(mockData: [
        ReverseGeocode::class => MockResponse::make('Nairobi, Kenya')
    ]);

    $address = Server::geocode(latitude: -1.286389, longitude: 36.817223);

    expect(value: $address)
        ->toBeString()
        ->toEqual(expected: 'Nairobi, Kenya');
});

test(description: 'can fetch server statistics between dates', closure: function () {
    $payload = [
        [
            'captureTime' => '2019-08-24T14:15:22Z',
            'requests'    => 120,
        ],
    ];

    MockClient::global(mockData: [
        GetServerStatistics::class => MockResponse::make($payload),
    ]);

    $from = CarbonImmutable::parse(time: '2019-08-24T00:00:00Z');
    $to = CarbonImmutable::parse(time: '2019-08-25T00:00:00Z');

    $stats = Server::statistics(from: $from, to: $to);

    expect(value: $stats)
        ->toBeInstanceOf(class: ServerStatisticsData::class);
});
