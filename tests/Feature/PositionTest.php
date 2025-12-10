<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Facades\Position;
use ThingsTelemetry\Traccar\Requests\DeletePosition;

it(description: 'can delete a position', closure: function () {
    MockClient::global(mockData: [
        DeletePosition::class => MockResponse::make(body: '', status: 204),
    ]);

    $result = Position::delete(id: 12345);

    expect(value: $result)
        ->toBeInstanceOf(class: StatusData::class)
        ->and(value: $result->status)->toEqual(expected: Status::SUCCESS);
});
