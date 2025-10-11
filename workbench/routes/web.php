<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::view('/', 'home.index')->name('home');

Route::get('/server', function () {
    return view(
        view: 'server.get-information',
        data: ['information' => \TrackTelemetry\Traccar\Facades\Server::getInformation()]
    );
})->name('server.get-information');

Route::get('/server/update', function () {
    $serverData = \TrackTelemetry\Traccar\Facades\Server::getInformation();

    $data = \TrackTelemetry\Traccar\Dto\ServerData::fromArray($serverData->toArray());
    $data->map = \TrackTelemetry\Traccar\Enums\Map::LOCATION_IQ_DARK;
    $data->attributes->speedUnit = \TrackTelemetry\Traccar\Enums\SpeedUnit::KILOMETERS_PER_HOUR;

    $response = \TrackTelemetry\Traccar\Facades\Server::updateInformation($data);

    return $response->toArray();
});
