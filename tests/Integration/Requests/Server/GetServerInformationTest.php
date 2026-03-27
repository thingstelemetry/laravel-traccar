<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Dto\ServerData;
use ThingsTelemetry\Traccar\Requests\Server\GetServerInformation;

test(description: 'it can get server information', closure: function () {
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
        GetServerInformation::class => MockResponse::make(body: $body)
    ]);

    $request = new GetServerInformation();
    $response = connector()->send(request: $request, mockClient: $mockClient);

    expect(value: $response->dto())
        ->toBeInstanceOf(class: ServerData::class)
        ->and(value: $response->dto()->id)->toBe(1)
        ->and(value: $response->dto()->version)->toBe('6.10.0');
});
