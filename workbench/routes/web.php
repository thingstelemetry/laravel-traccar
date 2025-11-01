<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/server');


Route::prefix('/server')->group(function () {
    Route::get('/', function () {
        dump(\TrackTelemetry\Traccar\Facades\Server::getInformation()->toArray());
    });

    Route::get('/update', function () {
        // Get info
        $data = \TrackTelemetry\Traccar\Facades\Server::getInformation();

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

    Route::get('/reboot', function () {
        $result = \TrackTelemetry\Traccar\Facades\Server::reboot();
        dump($result);
    });

    Route::get('/cache', function () {
        $cache = \TrackTelemetry\Traccar\Facades\Server::cache();

        dump($cache);
    });

    Route::get('/gc', function () {
        $result = \TrackTelemetry\Traccar\Facades\Server::gc();

        dump($result);
    });

    Route::get('/upload', function () {
        $path = request('path', 'web/readme.txt');

        $contents = 'Uploaded via workbench at ' . now()->toIso8601String();

        $tmp = tempnam(sys_get_temp_dir(), 'traccar_upload_');
        $tmpTxt = $tmp . '.txt';
        @rename($tmp, $tmpTxt);
        file_put_contents($tmpTxt, $contents);

        try {
            $result = \TrackTelemetry\Traccar\Facades\Server::uploadFile(path: $path, file: $tmpTxt);
        } finally {
            @unlink($tmpTxt);
        }

        dump(['path' => $path, 'status' => $result->status->value]);
    });

    Route::get('/timezones', function () {
        $zones = \TrackTelemetry\Traccar\Facades\Server::timezones();

        // Show a subset to keep output small
        dump($zones);
    });

    Route::get('/geocode', function () {
        $lat = request()->has('lat') ? (float)request('lat') : (request()->has('latitude') ? (float)request('latitude') : -1.286389);
        $lng = request()->has('lng') ? (float)request('lng') : (request()->has('longitude') ? (float)request('longitude') : 36.817223);

        $address = \TrackTelemetry\Traccar\Facades\Server::geocode(latitude: $lat, longitude: $lng);

        dump($address);
    });
});

Route::prefix('/devices')->group(function () {
    Route::get('/', function () {

        $userId = request('userId') ? (int)request('userId') : null;
        $ids = request('ids') ? explode(',', request('ids')) : null;
        $uniqueIds = request('uniqueIds') ? explode(',', request('uniqueIds')) : null;

        dump(\TrackTelemetry\Traccar\Facades\Device::get(
            userId: $userId,
            ids: $ids,
            uniqueIds: $uniqueIds
        ));
    });

    Route::get('/all', function () {
        dump(\TrackTelemetry\Traccar\Facades\Device::getAll());
    });

    Route::get('/create', function () {

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

    Route::get('/update', function () {

        // 1) Get an existing device (example: by uniqueId)
        $devices = \TrackTelemetry\Traccar\Facades\Device::get(uniqueIds: ['AX3WX9XT6ZYMPQWJ']);
        $data = $devices->first(); // TrackTelemetry\Traccar\Dto\DeviceData

        // 2) Update the DTO properties
        $data->name = 'Truck 1 - Updated';
        $data->attributes->speedLimit = 90.0;
        $data->groupId = 123456;

        // 3) Send the updated DTO
        $updated = \TrackTelemetry\Traccar\Facades\Device::update($data); //

        dump($updated);
    });

    Route::get('/update-totals', function () {

        $status = \TrackTelemetry\Traccar\Facades\Device::updateTotals(
            deviceId: 2,
            totalDistance: rand(1000, 100000),
            hours: rand(1, 100),
        );

        dump($status);
    });

    Route::get('/update-image', function () {
        $deviceId = request('deviceId') ? (int)request('deviceId') : 2;
        $url = 'https://github.com/tracktelemetry.png';

        $contents = @file_get_contents($url);
        if ($contents === false) {
            abort(500, 'Failed to download test image.');
        }

        // Write to a temporary file with .png extension to aid MIME detection
        $tmp = tempnam(sys_get_temp_dir(), 'traccar_img_');
        $tmpPng = $tmp . '.png';
        @rename($tmp, $tmpPng);

        file_put_contents($tmpPng, $contents);

        try {
            $filename = \TrackTelemetry\Traccar\Facades\Device::updateImage(
                deviceId: $deviceId,
                file: $tmpPng,
            );
        } finally {
            @unlink($tmpPng);
        }

        dump(['deviceId' => $deviceId, 'filename' => $filename]);
    });

    Route::get('/share', function () {
        $deviceId = request('deviceId') ? (int)request('deviceId') : 2;
        $hours = request('hours') ? (int)request('hours') : 12;

        $expiration = \Carbon\CarbonImmutable::now()->addHours($hours);

        $share = \TrackTelemetry\Traccar\Facades\Device::share(deviceId: $deviceId, expiration: $expiration);

        dump($share->toArray());
    });
});

Route::prefix('/events')->group(function () {
    Route::get('/{id}', function (int $id) {
        $event = \TrackTelemetry\Traccar\Facades\Event::get(id: $id);

        dump($event->toArray());
    });
});

Route::prefix('/users')->group(function () {
    Route::get('/all', function () {
        $users = \TrackTelemetry\Traccar\Facades\User::all();

        dump($users);
    });

    // TODO: Add create, update, delete routes

    Route::get('/{id}', function (int $id) {
        $user = \TrackTelemetry\Traccar\Facades\User::get(id: $id);

        dump($user->toArray());
    });
});
