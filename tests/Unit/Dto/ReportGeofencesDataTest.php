<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Tests\Unit\Dto;

use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Dto\ReportGeofencesData;

test('ReportGeofencesData fromArray and toArray round-trip', function () {
    $data = [
        'deviceId'   => 123,
        'deviceName' => 'Test Device',
        'geofenceId' => 456,
        'startTime'  => '2024-03-28T04:49:00Z',
        'endTime'    => '2024-03-28T05:49:00Z',
    ];

    $dto = ReportGeofencesData::fromArray(data: $data);

    expect(value: $dto)->toBeInstanceOf(class: ReportGeofencesData::class)
        ->and(value: $dto->deviceId)->toBe(expected: 123)
        ->and(value: $dto->deviceName)->toBe(expected: 'Test Device')
        ->and(value: $dto->geofenceId)->toBe(expected: 456)
        ->and(value: $dto->startTime)->toBeInstanceOf(class: CarbonImmutable::class)
        ->and(value: $dto->endTime)->toBeInstanceOf(class: CarbonImmutable::class);

    // Verify toArray() exists and returns expected data
    // This will fail until implemented
    expect(method_exists($dto, 'toArray'))->toBeTrue();

    $result = $dto->toArray();

    expect($result)->toBeArray()
        ->and($result['deviceId'])->toBe(123)
        ->and($result['deviceName'])->toBe('Test Device')
        ->and($result['geofenceId'])->toBe(456)
        ->and($result['startTime'])->toBe('2024-03-28T04:49:00+00:00')
        ->and($result['endTime'])->toBe('2024-03-28T05:49:00+00:00');
});

test('ReportGeofencesData handles missing or invalid timestamps by returning null', function () {
    $data = [
        'deviceId'   => 123,
        'deviceName' => 'Test Device',
        'geofenceId' => 456,
        'startTime'  => 'invalid-date',
        'endTime'    => null,
    ];

    $dto = ReportGeofencesData::fromArray(data: $data);

    expect($dto->startTime)->toBeNull()
        ->and($dto->endTime)->toBeNull();

    $result = $dto->toArray();
    expect($result['startTime'])->toBeNull()
        ->and($result['endTime'])->toBeNull();
});
