<?php

declare(strict_types=1);

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

$getGroupData = fn () => [
    'id'   => 1,
    'name' => 'Vehicles',
];

test(description: 'can get all groups', closure: function () use ($getGroupData) {
    MockClient::global(mockData: [
        GetAllGroups::class => MockResponse::make([$getGroupData()]),
    ]);

    $response = Group::getAll();

    expect(value: $response)
        ->toBeInstanceOf(class: Collection::class)
        ->and(value: $response)->toHaveCount(count: 1);
});

test(description: 'can get a single group by id', closure: function () use ($getGroupData) {
    MockClient::global(mockData: [
        GetGroup::class => MockResponse::make($getGroupData()),
    ]);

    $response = Group::get(id: 1);

    expect(value: $response)
        ->toBeInstanceOf(class: GroupData::class)
        ->and(value: $response->id)->toEqual(expected: 1);
});

test(description: 'can create a group', closure: function () use ($getGroupData) {
    MockClient::global(mockData: [
        CreateGroup::class => MockResponse::make($getGroupData()),
    ]);

    $data = GroupData::fromArray(data: $getGroupData());
    $response = Group::create(data: $data);

    expect(value: $response)
        ->toBeInstanceOf(class: GroupData::class)
        ->and(value: $response->id)->toEqual(expected: 1);
});

test(description: 'can update a group', closure: function () use ($getGroupData) {
    MockClient::global(mockData: [
        UpdateGroup::class => MockResponse::make($getGroupData()),
    ]);

    $data = GroupData::fromArray(data: $getGroupData());
    $response = Group::update(data: $data);

    expect(value: $response)
        ->toBeInstanceOf(class: GroupData::class)
        ->and(value: $response->id)->toEqual(expected: 1);
});

test(description: 'can delete a group', closure: function () {
    MockClient::global(mockData: [
        DeleteGroup::class => MockResponse::make(body: '', status: 204),
    ]);

    $result = Group::delete(id: 1);

    expect(value: $result)
        ->toBeInstanceOf(class: StatusData::class)
        ->and(value: $result->status)->toEqual(expected: Status::SUCCESS);
});
