<?php

declare(strict_types=1);

use Saloon\Http\Response;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Requests\Server\RunGarbageCollector;

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new RunGarbageCollector();

    expect(value: $request->resolveEndpoint())->toBe(expected: '/server/maintenance')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'POST');
});

test(description: 'it returns a success StatusData from response via createDtoFromResponse', closure: function () {
    $request = new RunGarbageCollector();
    $response = Response::fromMock(mockResponse: MockResponse::make(body: '', status: 204));

    $result = $request->createDtoFromResponse(response: $response);

    expect(value: $result)->toBeInstanceOf(class: StatusData::class)
        ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
});
