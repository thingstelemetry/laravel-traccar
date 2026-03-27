<?php

declare(strict_types=1);

namespace Tests\Integration\Requests\User;

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\TraccarConnector;
use ThingsTelemetry\Traccar\Requests\User\DeleteUser;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Enums\Status;

beforeEach(closure: function () {
    $this->connector = new TraccarConnector(
        baseUrl: 'https://demo.traccar.org/api',
        apiKey: 'test-api-key'
    );
});

test(description: 'it resolves the correct endpoint', closure: function () {
    $request = new DeleteUser(id: 6);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/users/6');
});

test(description: 'it returns a success StatusData from response via createDtoFromResponse', closure: function () {
    $mockClient = new MockClient(mockData: [
        DeleteUser::class => MockResponse::make(body: '', status: 204),
    ]);

    $request = new DeleteUser(id: 6);
    $response = $this->connector->send(request: $request, mockClient: $mockClient);

    $result = $response->dtoOrFail();

    expect(value: $result)->toBeInstanceOf(class: StatusData::class)
        ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
});
