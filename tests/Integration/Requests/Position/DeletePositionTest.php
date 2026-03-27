<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Requests\Position\DeletePosition;

test(description: 'it can delete a position', closure: function () {
    $mockClient = new MockClient(mockData: [
        DeletePosition::class => MockResponse::make(body: '', status: 204),
    ]);

    $request = new DeletePosition(id: 123);
    $response = connector()->send(request: $request, mockClient: $mockClient);

    expect(value: $response->dto())
        ->toBeInstanceOf(class: StatusData::class)
        ->and(value: $response->dto()->status)->toBe(Status::SUCCESS);
});
