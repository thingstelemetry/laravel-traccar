<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/server', function () {
    $response = \TrackTelemetry\Traccar\Facades\Server::getInformation();

    dd($response);
});
