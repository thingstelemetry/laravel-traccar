<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Tests\Unit\Dto;

use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Dto\ReportStopsData;

test('ReportStopsData fromArray and toArray round-trip', function () {
    $data = [
        'deviceId'    => 123,
        'deviceName'  => 'Test Device',
        'duration'    => 3600,
        'startTime'   => '2024-03-28T04:49:00Z',
        'address'     => '123 Test St',
        'lat'         => 1.2345,
        'lon'         => 6.7890,
        'endTime'     => '2024-03-28T05:49:00Z',
        'spentFuel'   => 1.5,
        'engineHours' => 10,
    ];

    $dto = ReportStopsData::fromArray(data: $data);

    expect(value: $dto)->toBeInstanceOf(class: ReportStopsData::class)
        ->and(value: $dto->deviceId)->toBe(expected: 123)
        ->and(value: $dto->deviceName)->toBe(expected: 'Test Device')
        ->and(value: $dto->duration)->toBe(expected: 3600)
        ->and(value: $dto->startTime)->toBeInstanceOf(class: CarbonImmutable::class)
        ->and(value: $dto->address)->toBe(expected: '123 Test St')
        ->and(value: $dto->lat)->toBe(expected: 1.2345)
        ->and(value: $dto->lon)->toBe(expected: 6.7890)
        ->and(value: $dto->endTime)->toBeInstanceOf(class: CarbonImmutable::class)
        ->and(value: $dto->spentFuel)->toBe(expected: 1.5)
        ->and(value: $dto->engineHours)->toBe(expected: 10);

    // Verify toArray() exists and returns expected data
    expect(method_exists($dto, 'toArray'))->toBeTrue();

    $result = $dto->toArray();

    expect($result)->toBeArray()
        ->and($result['deviceId'])->toBe(123)
        ->and($result['deviceName'])->toBe('Test Device')
        ->and($result['duration'])->toBe(3600)
        ->and($result['startTime'])->toBe('2024-03-28T04:49:00+00:00')
        ->and($result['address'])->toBe('123 Test St')
        ->and($result['lat'])->toBe(1.2345)
        ->and($result['lon'])->toBe(6.7890)
        ->and($result['endTime'])->toBe('2024-03-28T05:49:00+00:00')
        ->and($result['spentFuel'])->toBe(1.5)
        ->and($result['engineHours'])->toBe(10);
});
