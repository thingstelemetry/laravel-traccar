<?php

declare(strict_types=1);

use Saloon\Enums\Method;
use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Dto\CalendarData;
use ThingsTelemetry\Traccar\Facades\Calendar;
use ThingsTelemetry\Traccar\Requests\Calendar\CreateCalendar;
use ThingsTelemetry\Traccar\Requests\Calendar\DeleteCalendar;
use ThingsTelemetry\Traccar\Requests\Calendar\UpdateCalendar;
use ThingsTelemetry\Traccar\Requests\Calendar\GetAllCalendars;

$getCalendarData = fn () => [
    'id'   => 7,
    'name' => 'Working Hours',
    'data' => 'QkVHSU46VkNBTEVOREFS',
];

describe(description: 'get all', tests: function () use ($getCalendarData) {
    test(description: 'request sends the correct query parameters', closure: function () {
        $request = new GetAllCalendars(all: true, userId: 4, limit: 10, offset: 5, keyword: 'work');

        expect(value: $request->resolveEndpoint())->toBe(expected: '/calendars')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET)
            ->and(value: $request->query()->all())->toBe(expected: [
                'all'     => true,
                'userId'  => 4,
                'limit'   => 10,
                'offset'  => 5,
                'keyword' => 'work',
            ]);
    });

    test(description: 'returns all calendars', closure: function () use ($getCalendarData) {
        MockClient::global(mockData: [
            GetAllCalendars::class => MockResponse::make([$getCalendarData()]),
        ]);

        $response = Calendar::getAll();

        expect(value: $response)
            ->toBeInstanceOf(class: Collection::class)
            ->and(value: $response->first())->toBeInstanceOf(class: CalendarData::class);
    });
});

describe(description: 'create', tests: function () use ($getCalendarData) {
    test(description: 'request sends the correct body', closure: function () use ($getCalendarData) {
        $data = CalendarData::fromArray(data: $getCalendarData());
        $request = new CreateCalendar(data: $data);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/calendars')
            ->and(value: $request->getMethod())->toBe(expected: Method::POST)
            ->and(value: $request->body()->all())->toBe(expected: $data->toArray());
    });

    test(description: 'creates a calendar', closure: function () use ($getCalendarData) {
        MockClient::global(mockData: [
            CreateCalendar::class => MockResponse::make($getCalendarData()),
        ]);

        $response = Calendar::create(data: CalendarData::fromArray(data: $getCalendarData()));

        expect(value: $response)->toBeInstanceOf(class: CalendarData::class);
    });
});

describe(description: 'update', tests: function () use ($getCalendarData) {
    test(description: 'request sends the correct body', closure: function () use ($getCalendarData) {
        $data = CalendarData::fromArray(data: $getCalendarData());
        $request = new UpdateCalendar(data: $data);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/calendars/7')
            ->and(value: $request->getMethod())->toBe(expected: Method::PUT)
            ->and(value: $request->body()->all())->toBe(expected: $data->toArray());
    });

    test(description: 'updates a calendar', closure: function () use ($getCalendarData) {
        MockClient::global(mockData: [
            UpdateCalendar::class => MockResponse::make($getCalendarData()),
        ]);

        $response = Calendar::update(data: CalendarData::fromArray(data: $getCalendarData()));

        expect(value: $response)->toBeInstanceOf(class: CalendarData::class);
    });
});

describe(description: 'delete', tests: function () {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new DeleteCalendar(id: 7);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/calendars/7')
            ->and(value: $request->getMethod())->toBe(expected: Method::DELETE);
    });

    test(description: 'deletes a calendar', closure: function () {
        MockClient::global(mockData: [
            DeleteCalendar::class => MockResponse::make(body: '', status: 204),
        ]);

        $result = Calendar::delete(id: 7);

        expect(value: $result)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
    });
});
