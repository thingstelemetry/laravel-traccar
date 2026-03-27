<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Requests\Position\DeleteDevicePositions;

test(description: 'it can delete all positions for a device in a time range', closure: function () {
    $mockClient = new MockClient(mockData: [
        DeleteDevicePositions::class => MockResponse::make(body: '', status: 204),
    ]);

    $from = CarbonImmutable::parse(time: '2026-11-22T18:30:00Z');
    $to = CarbonImmutable::parse(time: '2026-11-23T18:30:00Z');

    $request = new DeleteDevicePositions(deviceId: 6, from: $from, to: $to);
    $response = connector()->send(request: $request, mockClient: $mockClient);

    expect(value: $response->dto())
        ->toBeInstanceOf(class: StatusData::class)
        ->and(value: $response->dto()->status)->toBe(Status::SUCCESS);
});
