<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Saloon\Http\PendingRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\ServerData;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Facades\Server;
use ThingsTelemetry\Traccar\Requests\RebootServer;
use Saloon\Exceptions\Request\FatalRequestException;
use ThingsTelemetry\Traccar\Requests\GetServerCache;
use ThingsTelemetry\Traccar\Requests\ReverseGeocode;
use ThingsTelemetry\Traccar\Dto\ServerStatisticsData;
use ThingsTelemetry\Traccar\Requests\UploadServerFile;
use ThingsTelemetry\Traccar\Requests\GetServerTimezones;
use ThingsTelemetry\Traccar\Requests\GetServerStatistics;
use ThingsTelemetry\Traccar\Requests\RunGarbageCollector;
use ThingsTelemetry\Traccar\Requests\GetServerInformation;
use ThingsTelemetry\Traccar\Requests\UpdateServerInformation;

beforeEach(closure: function () {
    $this->body = [
        "id"         => 1,
        "attributes" => [
            'speedUnit'    => 'kmh',
            'distanceUnit' => 'km',
        ],
        "registration"     => false,
        "readonly"         => false,
        "deviceReadonly"   => false,
        "map"              => null,
        "bingKey"          => null,
        "mapUrl"           => null,
        "overlayUrl"       => null,
        "latitude"         => 0.0,
        "longitude"        => 0.0,
        "zoom"             => 0,
        "forceSettings"    => false,
        "coordinateFormat" => null,
        "limitCommands"    => false,
        "disableReports"   => false,
        "fixedEmail"       => false,
        "poiLayer"         => null,
        "announcement"     => null,
        "emailEnabled"     => true,
        "geocoderEnabled"  => true,
        "textEnabled"      => false,
        "storageSpace"     => [
            0 => 40778186752,
            1 => 245107195904,
            2 => 324235,
            3 => 38552756224,
        ],
        "newServer"     => false,
        "openIdEnabled" => false,
        "openIdForce"   => false,
        "version"       => "6.10.0",
    ];
});

test(description: 'can get server information', closure: function () {
    MockClient::global(mockData: [
        GetServerInformation::class => MockResponse::make(body: $this->body)
    ]);

    $response = Server::getInformation();

    expect(value: $response)
        ->toBeInstanceOf(class: ServerData::class);
});

test(description: 'can update server information', closure: function () {
    MockClient::global(mockData: [
        UpdateServerInformation::class => MockResponse::make(body: $this->body)
    ]);

    $response = Server::updateInformation(ServerData::fromArray(data: $this->body));

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

test(description: 'treats empty reply as successful reboot', closure: function () {
    MockClient::global(mockData: [
        RebootServer::class => function (PendingRequest $pending) {
            throw new FatalRequestException(
                originalException: new RuntimeException(message: 'Empty reply from server', code: 52),
                pendingRequest: $pending
            );
        }
    ]);

    $result = Server::reboot();

    expect(value: $result)
        ->toBeInstanceOf(class: StatusData::class)
        ->and(value: $result->status)->toEqual(expected: Status::SUCCESS);
});

it(description: 'can fetch server cache string', closure: function () {
    MockClient::global(mockData: [
        GetServerCache::class => MockResponse::make('Cache{devices=123, users=45}')
    ]);

    $cache = Server::cache();

    expect(value: $cache)
        ->toBeString()
        ->toContain('Cache{');
});

it(description: 'can trigger garbage collector', closure: function () {
    MockClient::global(mockData: [
        RunGarbageCollector::class => MockResponse::make('', 204)
    ]);

    $result = Server::gc();

    expect(value: $result)
        ->toBeInstanceOf(class: StatusData::class)
        ->and(value: $result->status)->toEqual(expected: Status::SUCCESS);
});


it(description: 'can upload a file to server path', closure: function () {
    MockClient::global(mockData: [
        UploadServerFile::class => MockResponse::make('', 200)
    ]);

    $uploaded = UploadedFile::fake()->create(name: 'readme.txt', kilobytes: 1, mimeType: 'text/plain');

    $result = Server::uploadFile(path: 'web/readme.txt', file: $uploaded);

    expect(value: $result)
        ->toBeInstanceOf(class: StatusData::class)
        ->and(value: $result->status)->toEqual(expected: Status::SUCCESS);
});

it(description: 'can get server timezones', closure: function () {
    MockClient::global(mockData: [
        GetServerTimezones::class => MockResponse::make(['UTC', 'Africa/Nairobi'])
    ]);

    $zones = Server::timezones();

    expect(value: $zones)
        ->toBeInstanceOf(class: Collection::class)
        ->and(value: $zones)->toHaveCount(count: 2)
        ->and(value: $zones->contains('UTC'))->toBeTrue();
});

it(description: 'can reverse geocode coordinates', closure: function () {
    MockClient::global(mockData: [
        ReverseGeocode::class => MockResponse::make('Nairobi, Kenya')
    ]);

    $address = Server::geocode(latitude: -1.286389, longitude: 36.817223);

    expect(value: $address)
        ->toBeString()
        ->toEqual(expected: 'Nairobi, Kenya');
});

it(description: 'can fetch server statistics between dates', closure: function () {
    $payload = [
        [
            'captureTime'      => '2019-08-24T14:15:22Z',
            'activeUsers'      => 2,
            'activeDevices'    => 5,
            'requests'         => 120,
            'messagesReceived' => 450,
            'messagesStored'   => 440,
        ],
    ];

    MockClient::global(mockData: [
        GetServerStatistics::class => MockResponse::make($payload),
    ]);

    $from = CarbonImmutable::parse(time: '2019-08-24T00:00:00Z');
    $to = CarbonImmutable::parse(time: '2019-08-25T00:00:00Z');

    $stats = Server::statistics(from: $from, to: $to);

    expect(value: $stats)
        ->toBeInstanceOf(class: ServerStatisticsData::class)
        ->and(value: $stats->captureTime)->toBeInstanceOf(class: CarbonImmutable::class)
        ->and(value: $stats->activeUsers)->toEqual(expected: 2)
        ->and(value: $stats->messagesStored)->toEqual(expected: 440);
});
