<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/server', function () {
    $response = \TrackTelemetry\Traccar\Facades\Server::getInformation();

    return $response->toArray();
});

Route::get('/server/update', function () {
    $serverData = \TrackTelemetry\Traccar\Facades\Server::getInformation();

    $data = \TrackTelemetry\Traccar\Dto\ServerData::fromArray($serverData->toArray());
    $data->map = \TrackTelemetry\Traccar\Enums\Map::LOCATION_IQ_DARK;
    $data->attributes->speedUnit = \TrackTelemetry\Traccar\Enums\SpeedUnit::KILOMETERS_PER_HOUR;

    $response = \TrackTelemetry\Traccar\Facades\Server::updateInformation($data);

    return $response->toArray();
});
