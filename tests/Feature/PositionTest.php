<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Facades\Position;
use ThingsTelemetry\Traccar\Requests\Position\DeletePosition;
use ThingsTelemetry\Traccar\Requests\Position\DeleteDevicePositions;

test(description: 'can delete a position', closure: function () {
    MockClient::global(mockData: [
        DeletePosition::class => MockResponse::make(body: '', status: 204),
    ]);

    $result = Position::delete(id: 12345);

    expect(value: $result)
        ->toBeInstanceOf(class: StatusData::class)
        ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
});

test(description: 'can delete all positions for a device in a time range', closure: function () {
    MockClient::global(mockData: [
        DeleteDevicePositions::class => MockResponse::make(body: '', status: 204),
    ]);

    $from = CarbonImmutable::parse(time: '2026-11-22T18:30:00Z');
    $to = CarbonImmutable::parse(time: '2026-11-23T18:30:00Z');

    $result = Position::deleteForDeviceInRange(deviceId: 6, from: $from, to: $to);

    expect(value: $result)
        ->toBeInstanceOf(class: StatusData::class)
        ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
});
