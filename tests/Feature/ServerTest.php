<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use TrackTelemetry\Traccar\Facades\Server;
use TrackTelemetry\Traccar\Requests\GetServerInformation;

beforeEach(function () {
    $this->body = [
        "id"               => 1,
        "attributes"       => [],
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
            2 => 38552756224,
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
        ->toBeInstanceOf(class: \TrackTelemetry\Traccar\Dto\ServerData::class);
});
