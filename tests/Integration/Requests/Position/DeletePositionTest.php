<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\TraccarConnector;
use ThingsTelemetry\Traccar\Requests\Position\DeletePosition;

beforeEach(closure: function () {
    $this->connector = new TraccarConnector(
        baseUrl: 'https://demo.traccar.org/api',
        apiKey: 'test-api-key'
    );
});

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new DeletePosition(id: 123);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/positions/123')
        ->and(value: $request->getMethod()->value)->toBe(expected: 'DELETE');
});

test(description: 'it returns a success StatusData from response via createDtoFromResponse', closure: function () {
    $mockClient = new MockClient(mockData: [
        DeletePosition::class => MockResponse::make(body: '', status: 204),
    ]);

    $request = new DeletePosition(id: 123);
    $response = $this->connector->send(request: $request, mockClient: $mockClient);

    $result = $response->dtoOrFail();

    expect(value: $result)->toBeInstanceOf(class: StatusData::class)
        ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
});
