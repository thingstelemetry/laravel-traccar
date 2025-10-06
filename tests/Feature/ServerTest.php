<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use TrackTelemetry\Traccar\Facades\Server;
use TrackTelemetry\Traccar\Requests\GetServerInformation;

beforeEach(function () {
    $this->body = [
        'id'               => 0,
        'registration'     => true,
        'readonly'         => true,
        'deviceReadonly'   => true,
        'limitCommands'    => true,
        'map'              => 'string',
        'bingKey'          => 'string',
        'mapUrl'           => 'string',
        'poiLayer'         => 'string',
        'latitude'         => 0,
        'longitude'        => 0,
        'zoom'             => 0,
        'version'          => 'string',
        'forceSettings'    => true,
        'coordinateFormat' => 'string',
        'openIdEnabled'    => true,
        'openIdForce'      => true,
        'attributes'       => [],
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
