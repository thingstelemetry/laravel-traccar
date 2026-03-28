<?php

declare(strict_types=1);

use Saloon\Enums\Method;
use Carbon\CarbonImmutable;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Facades\Position;
use ThingsTelemetry\Traccar\Requests\Position\DeletePosition;
use ThingsTelemetry\Traccar\Requests\Position\DeleteDevicePositions;

describe(description: 'delete', tests: function () {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new DeletePosition(id: 12345);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/positions/12345')
            ->and(value: $request->getMethod())->toBe(expected: Method::DELETE);
    });

    test(description: 'deletes a position', closure: function () {
        MockClient::global(mockData: [
            DeletePosition::class => MockResponse::make(body: '', status: 204),
        ]);

        $result = Position::delete(id: 12345);

        expect(value: $result)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
    });
});

describe(description: 'delete for device in range', tests: function () {
    test(description: 'request sends the correct query parameters', closure: function () {
        $from = CarbonImmutable::parse(time: '2026-11-22T18:30:00Z');
        $to = CarbonImmutable::parse(time: '2026-11-23T18:30:00Z');
        $request = new DeleteDevicePositions(deviceId: 6, from: $from, to: $to);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/positions')
            ->and(value: $request->getMethod())->toBe(expected: Method::DELETE)
            ->and(value: $request->query()->all())->toBe(expected: [
                'deviceId' => 6,
                'from'     => $from->toIso8601String(),
                'to'       => $to->toIso8601String(),
            ]);
    });

    test(description: 'deletes positions for a device in a time range', closure: function () {
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
});
