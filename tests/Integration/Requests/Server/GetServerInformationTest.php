<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\ServerData;
use ThingsTelemetry\Traccar\TraccarConnector;
use ThingsTelemetry\Traccar\Requests\Server\GetServerInformation;

beforeEach(closure: function () {
    $this->connector = new TraccarConnector(
        baseUrl: 'https://demo.traccar.org/api',
        apiKey: 'test-api-key'
    );
});

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new GetServerInformation();

    expect(value: $request->resolveEndpoint())->toBe(expected: '/server')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'GET');
});

test(description: 'it creates a ServerData DTO from response via createDtoFromResponse', closure: function () {
    $body = [
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

    $mockClient = new MockClient(mockData: [
        GetServerInformation::class => MockResponse::make(body: $body, status: 200),
    ]);

    $request = new GetServerInformation();
    $response = $this->connector->send(request: $request, mockClient: $mockClient);

    $server = $response->dtoOrFail();

    expect(value: $server)->toBeInstanceOf(class: ServerData::class)
        ->and(value: $server->id)->toBe(1)
        ->and(value: $server->version)->toBe('6.10.0');
});
