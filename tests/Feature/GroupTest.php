<?php

declare(strict_types=1);

use Saloon\Enums\Method;
use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\GroupData;
use ThingsTelemetry\Traccar\Facades\Group;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Requests\Group\GetGroup;
use ThingsTelemetry\Traccar\Requests\Group\CreateGroup;
use ThingsTelemetry\Traccar\Requests\Group\DeleteGroup;
use ThingsTelemetry\Traccar\Requests\Group\UpdateGroup;
use ThingsTelemetry\Traccar\Requests\Group\GetAllGroups;
use Saloon\Exceptions\Request\Statuses\NotFoundException;

$getGroupData = fn () => [
    'id'   => 1,
    'name' => 'Vehicles',
];

describe(description: 'all', tests: function () use ($getGroupData) {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new GetAllGroups();

        expect(value: $request->resolveEndpoint())->toBe(expected: '/groups')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET);
    });

    test(description: 'returns all groups', closure: function () use ($getGroupData) {
        MockClient::global(mockData: [
            GetAllGroups::class => MockResponse::make([$getGroupData()]),
        ]);

        $response = Group::all();

        expect(value: $response)
            ->toBeInstanceOf(class: Collection::class)
            ->and(value: $response)->toHaveCount(count: 1);
    });

    test(description: 'propagates errors', closure: function () {
        MockClient::global(mockData: [
            GetAllGroups::class => MockResponse::make(body: [], status: 500),
        ]);

        expect(value: fn () => Group::all())
            ->toThrow(exception: \Saloon\Exceptions\Request\RequestException::class);
    });
});

describe(description: 'get', tests: function () use ($getGroupData) {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new GetGroup(id: 1);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/groups/1')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET);
    });

    test(description: 'returns a single group by id', closure: function () use ($getGroupData) {
        MockClient::global(mockData: [
            GetGroup::class => MockResponse::make($getGroupData()),
        ]);

        $response = Group::get(id: 1);

        expect(value: $response)
            ->toBeInstanceOf(class: GroupData::class)
            ->and(value: $response->id)->toBe(expected: 1);
    });

    test(description: 'throws not found when the group response is empty', closure: function () {
        MockClient::global(mockData: [
            GetGroup::class => MockResponse::make(body: [], status: 200),
        ]);

        expect(value: fn () => Group::get(id: 999))
            ->toThrow(exception: NotFoundException::class, exceptionMessage: 'Traccar group was not found. Check the group ID and try again.');
    });
});

describe(description: 'create', tests: function () use ($getGroupData) {
    test(description: 'request sends the correct body', closure: function () use ($getGroupData) {
        $data = GroupData::fromArray(data: $getGroupData());
        $request = new CreateGroup(data: $data);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/groups')
            ->and(value: $request->getMethod())->toBe(expected: Method::POST)
            ->and(value: $request->body()->all())->toBe(expected: $data->toArray());
    });

    test(description: 'creates a group', closure: function () use ($getGroupData) {
        MockClient::global(mockData: [
            CreateGroup::class => MockResponse::make($getGroupData()),
        ]);

        $data = GroupData::fromArray(data: $getGroupData());
        $response = Group::create(data: $data);

        expect(value: $response)
            ->toBeInstanceOf(class: GroupData::class)
            ->and(value: $response->id)->toBe(expected: 1);
    });

    test(description: 'propagates errors', closure: function () use ($getGroupData) {
        MockClient::global(mockData: [
            CreateGroup::class => MockResponse::make(body: [], status: 400),
        ]);

        expect(value: fn () => Group::create(data: GroupData::fromArray(data: $getGroupData())))
            ->toThrow(exception: \Saloon\Exceptions\Request\RequestException::class);
    });
});

describe(description: 'update', tests: function () use ($getGroupData) {
    test(description: 'request sends the correct body', closure: function () use ($getGroupData) {
        $data = GroupData::fromArray(data: $getGroupData());
        $request = new UpdateGroup(data: $data);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/groups/1')
            ->and(value: $request->getMethod())->toBe(expected: Method::PUT)
            ->and(value: $request->body()->all())->toBe(expected: $data->toArray());
    });

    test(description: 'updates a group', closure: function () use ($getGroupData) {
        MockClient::global(mockData: [
            UpdateGroup::class => MockResponse::make($getGroupData()),
        ]);

        $data = GroupData::fromArray(data: $getGroupData());
        $response = Group::update(data: $data);

        expect(value: $response)
            ->toBeInstanceOf(class: GroupData::class)
            ->and(value: $response->id)->toBe(expected: 1);
    });

    test(description: 'propagates errors', closure: function () use ($getGroupData) {
        MockClient::global(mockData: [
            UpdateGroup::class => MockResponse::make(body: [], status: 404),
        ]);

        expect(value: fn () => Group::update(data: GroupData::fromArray(data: $getGroupData())))
            ->toThrow(exception: \Saloon\Exceptions\Request\RequestException::class);
    });
});

describe(description: 'delete', tests: function () {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new DeleteGroup(id: 1);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/groups/1')
            ->and(value: $request->getMethod())->toBe(expected: Method::DELETE);
    });

    test(description: 'deletes a group', closure: function () {
        MockClient::global(mockData: [
            DeleteGroup::class => MockResponse::make(body: '', status: 204),
        ]);

        $result = Group::delete(id: 1);

        expect(value: $result)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
    });

    test(description: 'propagates errors', closure: function () {
        MockClient::global(mockData: [
            DeleteGroup::class => MockResponse::make(body: [], status: 500),
        ]);

        expect(value: fn () => Group::delete(id: 1))
            ->toThrow(exception: \Saloon\Exceptions\Request\RequestException::class);
    });
});
