<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/server');


Route::prefix('/server')->group(function () {
    Route::get('/', function () {
        dump(\ThingsTelemetry\Traccar\Facades\Server::getInformation()->toArray());
    });

    Route::get('/update', function () {
        // Get info
        $data = \ThingsTelemetry\Traccar\Facades\Server::getInformation();

        // Update
        $data->map = \ThingsTelemetry\Traccar\Enums\Map::LOCATION_IQ_DARK;
        $data->attributes->speedUnit = \ThingsTelemetry\Traccar\Enums\SpeedUnit::KILOMETERS_PER_HOUR;
        $data->attributes->distanceUnit = \ThingsTelemetry\Traccar\Enums\DistanceUnit::KILOMETERS;
        $data->attributes->altitudeUnit = \ThingsTelemetry\Traccar\Enums\AltitudeUnit::METERS;
        $data->attributes->volumeUnit = \ThingsTelemetry\Traccar\Enums\VolumeUnit::LITERS;

        // Send
        $response = \ThingsTelemetry\Traccar\Facades\Server::updateInformation($data);

        dd($response);
    });

    Route::get('/reboot', function () {
        $result = \ThingsTelemetry\Traccar\Facades\Server::reboot();
        dump($result);
    });

    Route::get('/cache', function () {
        $cache = \ThingsTelemetry\Traccar\Facades\Server::cache();

        dump($cache);
    });

    Route::get('/gc', function () {
        $result = \ThingsTelemetry\Traccar\Facades\Server::gc();

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
            $result = \ThingsTelemetry\Traccar\Facades\Server::uploadFile(path: $path, file: $tmpTxt);
        } finally {
            @unlink($tmpTxt);
        }

        dump(['path' => $path, 'status' => $result->status->value]);
    });

    Route::get('/timezones', function () {
        $zones = \ThingsTelemetry\Traccar\Facades\Server::timezones();

        // Show a subset to keep output small
        dump($zones);
    });

    Route::get('/geocode', function () {
        $lat = request()->has('lat') ? (float)request('lat') : (request()->has('latitude') ? (float)request('latitude') : -1.286389);
        $lng = request()->has('lng') ? (float)request('lng') : (request()->has('longitude') ? (float)request('longitude') : 36.817223);

        $address = \ThingsTelemetry\Traccar\Facades\Server::geocode(latitude: $lat, longitude: $lng);

        dump($address);
    });

    Route::get('/statistics', function () {

        $stats = \ThingsTelemetry\Traccar\Facades\Server::statistics(
            from: \Carbon\CarbonImmutable::parse(time: '01 Oct 2025'),
            to: \Carbon\CarbonImmutable::parse(time: '31 Nov 2025')
        );

        dump($stats);
    });
});

Route::prefix('/devices')->group(function () {
    Route::get('/', function () {

        $userId = request('userId') ? (int)request('userId') : null;
        $ids = request('ids') ? explode(',', request('ids')) : null;
        $uniqueIds = request('uniqueIds') ? explode(',', request('uniqueIds')) : null;

        dump(\ThingsTelemetry\Traccar\Facades\Device::get(
            userId: $userId,
            ids: $ids,
            uniqueIds: $uniqueIds
        ));
    });

    Route::get('/all', function () {
        dump(\ThingsTelemetry\Traccar\Facades\Device::getAll());
    });

    Route::get('/create', function () {

        $attributes = new \ThingsTelemetry\Traccar\Dto\DeviceAttributesData(
            speedLimit: 80,
            fuelDropThreshold: 5.0,
            fuelIncreaseThreshold: 10,
            reportIgnoreOdometer: false,
            devicePassword: '34235',
        );

        $deviceData = new \ThingsTelemetry\Traccar\Dto\DeviceData(
            name: 'My Vehicle',
            uniqueId: mb_strtoupper(Illuminate\Support\Str::random()),
            attributes: $attributes, // ignored on create
            status: \ThingsTelemetry\Traccar\Enums\DeviceStatus::UNKNOWN,
            disabled: false,
            phone: '+254722000000',
            model: 'Teltonika FMB920',
            contact: 'Thigs Telemetry Developer',
            category: \ThingsTelemetry\Traccar\Enums\DeviceCategory::CAR,
        );

        $device = \ThingsTelemetry\Traccar\Facades\Device::create($deviceData);

        dump($device);
    });

    Route::get('/update', function () {

        // 1) Get an existing device (example: by uniqueId)
        $devices = \ThingsTelemetry\Traccar\Facades\Device::get(uniqueIds: ['AX3WX9XT6ZYMPQWJ']);
        $data = $devices->first(); // ThingsTelemetry\Traccar\Dto\DeviceData

        // 2) Update the DTO properties
        $data->name = 'Truck 1 - Updated';
        $data->attributes->speedLimit = 90.0;
        $data->groupId = 123456;

        // 3) Send the updated DTO
        $updated = \ThingsTelemetry\Traccar\Facades\Device::update($data); //

        dump($updated);
    });

    Route::get('/update-totals', function () {

        $status = \ThingsTelemetry\Traccar\Facades\Device::updateTotals(
            deviceId: 2,
            totalDistance: rand(1000, 100000),
            hours: rand(1, 100),
        );

        dump($status);
    });

    Route::get('/update-image', function () {
        $deviceId = request('deviceId') ? (int)request('deviceId') : 2;
        $url = 'https://github.com/thingstelemetry.png';

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
            $filename = \ThingsTelemetry\Traccar\Facades\Device::updateImage(
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

        $share = \ThingsTelemetry\Traccar\Facades\Device::share(deviceId: $deviceId, expiration: $expiration);

        dump($share->toArray());
    });
});

Route::prefix('/events')->group(function () {
    Route::get('/{id}', function (int $id) {
        $event = \ThingsTelemetry\Traccar\Facades\Event::get(id: $id);

        dump($event->toArray());
    });
});

Route::prefix('/users')->group(function () {
    Route::get('/all', function () {
        $users = \ThingsTelemetry\Traccar\Facades\User::all();

        dump($users);
    });

    Route::get('/create', function () {

        $attributes = new \ThingsTelemetry\Traccar\Dto\UserAttributesData(
            language: 'en',
            mapGeofences: true,
        );

        $data = new \ThingsTelemetry\Traccar\Dto\UserData(
            id: 0, // ignored on create
            name: fake()->name(),
            email: fake()->email(),
            phone: fake()->e164PhoneNumber(),
            readonly: false,
            administrator: false,
            map: \ThingsTelemetry\Traccar\Enums\Map::OSM,
            latitude: 0.0,
            longitude: 0.0,
            zoom: 0,
            password: 'secret',
            coordinateFormat: \ThingsTelemetry\Traccar\Enums\CoordinateFormat::DD,
            disabled: false,
            expirationTime: null,
            deviceLimit: 0,
            userLimit: 0,
            deviceReadonly: false,
            limitCommands: false,
            fixedEmail: false,
            poiLayer: null,
            attributes: $attributes,
        );

        $created = \ThingsTelemetry\Traccar\Facades\User::create($data);

        dd($created);
    });

    Route::get('/update/{id}', function (int $id) {
        $data = \ThingsTelemetry\Traccar\Facades\User::get(id: $id);

        $data->email = fake()->email();
        $data->phone = fake()->e164PhoneNumber();
        $data->name = fake()->name();
        $data->disabled = true;

        $updated = \ThingsTelemetry\Traccar\Facades\User::update($data);

        dd($updated);
    });

    Route::get('/delete/{id}', function (int $id) {
        $data = \ThingsTelemetry\Traccar\Facades\User::delete(id: $id);

        dd($data);
    });

    Route::get('/{id}', function (int $id) {
        $user = \ThingsTelemetry\Traccar\Facades\User::get(id: $id);

        dump($user->toArray());
    });
});

Route::prefix('/positions')->group(function () {
    Route::get('/delete/{id}', function (int $id) {
        // Example endpoint to test deleting a single position by ID
        $result = \ThingsTelemetry\Traccar\Facades\Position::delete(id: $id);

        dd($result);
    });

    Route::get('/delete-range/{id}/{from}/{to}', function (int $id, int $from, int $to) {

        $result = \ThingsTelemetry\Traccar\Facades\Position::deleteForDeviceInRange(
            deviceId: $id,
            from: now()->subMinutes($from),
            to: now()->subMinutes($to),
        );

        dd($result);
    });
});
