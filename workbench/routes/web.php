<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/server');

Route::get('/server', function () {
    dump(\TrackTelemetry\Traccar\Facades\Server::getInformation()->toArray()) ;
});

Route::get('/server/update', function () {
    // Get info
    $serverData = \TrackTelemetry\Traccar\Facades\Server::getInformation();

    // Clone
    $data = \TrackTelemetry\Traccar\Dto\ServerData::fromArray($serverData->toArray());

    // Update
    $data->map = \TrackTelemetry\Traccar\Enums\Map::LOCATION_IQ_DARK;
    $data->attributes->speedUnit = \TrackTelemetry\Traccar\Enums\SpeedUnit::KILOMETERS_PER_HOUR;

    // Send
    $response = \TrackTelemetry\Traccar\Facades\Server::updateInformation($data);

    dd($response);
});
