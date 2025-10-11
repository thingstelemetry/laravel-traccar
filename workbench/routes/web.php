<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/server');

Route::get('/server', function () {
    dump(\TrackTelemetry\Traccar\Facades\Server::getInformation()->toArray());
});

Route::get('/server/update', function () {
    // Get info
    $serverData = \TrackTelemetry\Traccar\Facades\Server::getInformation();

    // Clone
    $data = \TrackTelemetry\Traccar\Dto\ServerData::fromArray($serverData->toArray());

    // Update
    $data->map = \TrackTelemetry\Traccar\Enums\Map::LOCATION_IQ_DARK;
    $data->attributes->speedUnit = \TrackTelemetry\Traccar\Enums\SpeedUnit::KILOMETERS_PER_HOUR;
    $data->attributes->distanceUnit = \TrackTelemetry\Traccar\Enums\DistanceUnit::KILOMETERS;
    $data->attributes->altitudeUnit = \TrackTelemetry\Traccar\Enums\AltitudeUnit::METERS;
    $data->attributes->volumeUnit = \TrackTelemetry\Traccar\Enums\VolumeUnit::LITERS;

    // Send
    $response = \TrackTelemetry\Traccar\Facades\Server::updateInformation($data);

    dd($response);
});

Route::get('/devices/all', function () {
    dump(\TrackTelemetry\Traccar\Facades\Device::getAll());
});

Route::get('/devices', function () {

    $userId = request('userId') ? (int)request('userId') : null;
    $ids = request('ids') ? explode(',', request('ids')) : null;
    $uniqueIds = request('uniqueIds') ? explode(',', request('uniqueIds')) : null;

    dump(\TrackTelemetry\Traccar\Facades\Device::get(
        userId: $userId,
        ids: $ids,
        uniqueIds: $uniqueIds
    ));
});

Route::get('/devices/create', function () {

    $attributes = new \TrackTelemetry\Traccar\Dto\DeviceAttributesData(
        speedLimit: 80,
        fuelDropThreshold: 5.0,
        fuelIncreaseThreshold: 10,
        reportIgnoreOdometer: false,
        devicePassword: '34235',
    );

    $deviceData = new \TrackTelemetry\Traccar\Dto\DeviceData(
        name: 'My Vehicle',
        uniqueId: mb_strtoupper(Illuminate\Support\Str::random()),
        status: \TrackTelemetry\Traccar\Enums\DeviceStatus::UNKNOWN, // ignored on create
        disabled: false,
        phone: '+254722000000',
        model: 'Teltonika FMB920',
        contact: 'Track Telemetry Developer',
        category: \TrackTelemetry\Traccar\Enums\DeviceCategory::CAR,
        attributes: $attributes,
    );

    $device = \TrackTelemetry\Traccar\Facades\Device::create($deviceData);

    dump($device);
});

Route::get('/devices/update', function () {

    // 1) Get an existing device (example: by uniqueId)
    $devices = \TrackTelemetry\Traccar\Facades\Device::get(uniqueIds: ['AX3WX9XT6ZYMPQWJ']);
    $device = $devices->first(); // TrackTelemetry\\Traccar\\Dto\\DeviceData

    // 2) Clone the DTO so you can safely mutate values
    $data = \TrackTelemetry\Traccar\Dto\DeviceData::fromArray($device->toArray());

    // 3) Update the clone as needed
    $data->name = 'Truck 1 - Updated';
    $data->attributes->speedLimit = 90.0;
    $data->groupId = 123456;

    // 4) Send the updated DTO
    $updated = \TrackTelemetry\Traccar\Facades\Device::update($data); //

    dump($updated);
});

Route::get('/devices/update-totals', function () {

    $status = \TrackTelemetry\Traccar\Facades\Device::updateTotals(
        deviceId: 2,
        totalDistance: rand(1000, 100000),
        hours: rand(1, 100),
    );

    dump($status);
});
