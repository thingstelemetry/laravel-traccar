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
use Saloon\Exceptions\Request\Statuses\NotFoundException;

beforeEach(closure: function () {
    $this->groups = [
        [
            'id'         => 1,
            'name'       => 'Vehicles',
            'groupId'    => null,
            'attributes' => [],
        ],
        [
            'id'         => 2,
            'name'       => 'Trucks',
            'groupId'    => 1,
            'attributes' => [
                'color' => 'blue',
            ],
        ],
    ];
});

it(description: 'can get all groups', closure: function () {
    MockClient::global(mockData: [
        GetAllGroups::class => MockResponse::make($this->groups),
    ]);

    $response = Group::getAll();

    expect(value: $response)
        ->toBeInstanceOf(class: Collection::class)
        ->and(value: $response)->toHaveCount(count: 2);

    $first = $response->first();
    expect(value: $first)
        ->toBeInstanceOf(class: GroupData::class)
        ->and(value: $first->name)->toEqual(expected: 'Vehicles')
        ->and(value: $first->groupId)->toBeNull()
        ->and(value: $first->attributes)->toBeArray();
});

it(description: 'can get all groups with filters', closure: function () {
    MockClient::global(mockData: [
        GetAllGroups::class => MockResponse::make($this->groups),
    ]);

    $response = Group::getAll(all: true, userId: 42, excludeAttributes: true);

    expect(value: $response)
        ->toBeInstanceOf(class: Collection::class)
        ->and(value: $response)->toHaveCount(count: 2);
});

it(description: 'can get a single group by id', closure: function () {
    MockClient::global(mockData: [
        GetGroup::class => MockResponse::make($this->groups[0]),
    ]);

    $response = Group::get(id: 1);

    expect(value: $response)
        ->toBeInstanceOf(class: GroupData::class)
        ->and(value: $response->id)->toEqual(expected: 1)
        ->and(value: $response->name)->toEqual(expected: 'Vehicles')
        ->and(value: $response->groupId)->toBeNull()
        ->and(value: $response->attributes)->toBeArray();
});

it(description: 'throws exception when group not found', closure: function () {
    MockClient::global(mockData: [
        GetGroup::class => MockResponse::make(body: [], status: 404),
    ]);

    expect(value: fn () => Group::get(id: 999))
        ->toThrow(exception: NotFoundException::class);
});

it(description: 'can create a group', closure: function () {
    $created = [
        'id'         => 3,
        'name'       => 'New Group',
        'groupId'    => 1,
        'attributes' => [
            'color' => 'red',
        ],
    ];

    MockClient::global(mockData: [
        CreateGroup::class => MockResponse::make($created),
    ]);

    $requestData = GroupData::fromArray(data: $created);

    $response = Group::create(data: $requestData);

    expect(value: $response)
        ->toBeInstanceOf(class: GroupData::class)
        ->and(value: $response->id)->toEqual(expected: 3)
        ->and(value: $response->name)->toEqual(expected: 'New Group')
        ->and(value: $response->groupId)->toEqual(expected: 1)
        ->and(value: $response->attributes)->toBeArray()
        ->and(value: $response->attributes['color'])->toEqual(expected: 'red');
});

it(description: 'can update a group', closure: function () {
    $updated = [
        'id'         => 1,
        'name'       => 'Updated Group',
        'groupId'    => null,
        'attributes' => [
            'color' => 'green',
        ],
    ];

    MockClient::global(mockData: [
        UpdateGroup::class => MockResponse::make($updated),
    ]);

    $data = GroupData::fromArray(data: $updated);

    $response = Group::update(data: $data);

    expect(value: $response)
        ->toBeInstanceOf(class: GroupData::class)
        ->and(value: $response->id)->toEqual(expected: 1)
        ->and(value: $response->name)->toEqual(expected: 'Updated Group')
        ->and(value: $response->attributes['color'])->toEqual(expected: 'green');
});

it(description: 'throws exception when updating group without id', closure: function () {
    $data = new GroupData(
        name: 'Group Without ID',
        attributes: []
    );

    expect(value: fn () => Group::update(data: $data))
        ->toThrow(exception: InvalidArgumentException::class);
});

it(description: 'can delete a group', closure: function () {
    MockClient::global(mockData: [
        DeleteGroup::class => MockResponse::make(body: '', status: 204),
    ]);

    $result = Group::delete(id: 1);

    expect(value: $result)
        ->toBeInstanceOf(class: StatusData::class)
        ->and(value: $result->status)->toEqual(expected: Status::SUCCESS);
});

it(description: 'can create group with parent group', closure: function () {
    $created = [
        'id'         => 4,
        'name'       => 'Child Group',
        'groupId'    => 1,
        'attributes' => [],
    ];

    MockClient::global(mockData: [
        CreateGroup::class => MockResponse::make($created),
    ]);

    $requestData = GroupData::fromArray(data: $created);

    $response = Group::create(data: $requestData);

    expect(value: $response)
        ->toBeInstanceOf(class: GroupData::class)
        ->and(value: $response->groupId)->toEqual(expected: 1);
});

it(description: 'can convert group data to array', closure: function () {
    $data = new GroupData(
        id: 1,
        name: 'Test Group',
        groupId: null,
        attributes: [
            'color' => 'blue',
            'icon'  => 'truck',
        ]
    );

    $array = $data->toArray();

    expect(value: $array)
        ->toBeArray()
        ->and(value: $array['id'])->toEqual(expected: 1)
        ->and(value: $array['name'])->toEqual(expected: 'Test Group')
        ->and(value: $array['groupId'])->toBeNull()
        ->and(value: $array['attributes'])->toBeArray()
        ->and(value: $array['attributes']['color'])->toEqual(expected: 'blue')
        ->and(value: $array['attributes']['icon'])->toEqual(expected: 'truck');
});

it(description: 'can create group data from array', closure: function () {
    $array = [
        'id'         => 5,
        'name'       => 'From Array',
        'groupId'    => 2,
        'attributes' => [
            'priority' => 'high',
        ],
    ];

    $data = GroupData::fromArray(data: $array);

    expect(value: $data)
        ->toBeInstanceOf(class: GroupData::class)
        ->and(value: $data->id)->toEqual(expected: 5)
        ->and(value: $data->name)->toEqual(expected: 'From Array')
        ->and(value: $data->groupId)->toEqual(expected: 2)
        ->and(value: $data->attributes['priority'])->toEqual(expected: 'high');
});
