<?php

declare(strict_types=1);

use Saloon\Enums\Method;
use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use Saloon\Exceptions\Request\RequestException;
use ThingsTelemetry\Traccar\Dto\NotificationData;
use ThingsTelemetry\Traccar\Facades\Notification;
use ThingsTelemetry\Traccar\Dto\NotificationTypeData;
use ThingsTelemetry\Traccar\Dto\NotificationMessageData;
use ThingsTelemetry\Traccar\Requests\Notification\GetNotificators;
use ThingsTelemetry\Traccar\Requests\Notification\SendNotification;
use ThingsTelemetry\Traccar\Requests\Notification\CreateNotification;
use ThingsTelemetry\Traccar\Requests\Notification\DeleteNotification;
use ThingsTelemetry\Traccar\Requests\Notification\UpdateNotification;
use ThingsTelemetry\Traccar\Requests\Notification\GetAllNotifications;
use ThingsTelemetry\Traccar\Requests\Notification\GetNotificationTypes;
use ThingsTelemetry\Traccar\Requests\Notification\SendTestNotification;

$getNotificationData = fn () => [
    'id'           => 41,
    'type'         => 'ignitionOn',
    'description'  => 'Engine started',
    'always'       => false,
    'commandId'    => 21,
    'notificators' => 'web,mail',
    'calendarId'   => 7,
    'attributes'   => ['sound' => 'beep'],
];

describe(description: 'all', tests: function () use ($getNotificationData) {
    test(description: 'request sends the correct query parameters', closure: function () {
        $request = new GetAllNotifications(all: true, userId: 1, deviceId: 6, groupId: 7, refresh: true, limit: 10, offset: 2, keyword: 'engine');

        expect(value: $request->resolveEndpoint())->toBe(expected: '/notifications')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET)
            ->and(value: $request->query()->all())->toBe(expected: [
                'all'      => true,
                'userId'   => 1,
                'deviceId' => 6,
                'groupId'  => 7,
                'refresh'  => true,
                'limit'    => 10,
                'offset'   => 2,
                'keyword'  => 'engine',
            ]);
    });

    test(description: 'returns all notifications', closure: function () use ($getNotificationData) {
        MockClient::global(mockData: [
            GetAllNotifications::class => MockResponse::make([$getNotificationData()]),
        ]);

        $response = Notification::all();

        expect(value: $response)
            ->toBeInstanceOf(class: Collection::class)
            ->and(value: $response->first())->toBeInstanceOf(class: NotificationData::class);
    });

    test(description: 'propagates errors', closure: function () {
        MockClient::global(mockData: [
            GetAllNotifications::class => MockResponse::make(body: [], status: 500),
        ]);

        expect(value: fn () => Notification::all())->toThrow(exception: RequestException::class);
    });
});

describe(description: 'create and update', tests: function () use ($getNotificationData) {
    test(description: 'create request sends the correct body', closure: function () use ($getNotificationData) {
        $data = NotificationData::fromArray(data: $getNotificationData());
        $request = new CreateNotification(data: $data);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/notifications')
            ->and(value: $request->getMethod())->toBe(expected: Method::POST)
            ->and(value: $request->body()->all())->toBe(expected: $data->toArray());
    });

    test(description: 'update request sends the correct body', closure: function () use ($getNotificationData) {
        $data = NotificationData::fromArray(data: $getNotificationData());
        $request = new UpdateNotification(data: $data);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/notifications/41')
            ->and(value: $request->getMethod())->toBe(expected: Method::PUT)
            ->and(value: $request->body()->all())->toBe(expected: $data->toArray());
    });

    test(description: 'creates and updates a notification', closure: function () use ($getNotificationData) {
        MockClient::global(mockData: [
            CreateNotification::class => MockResponse::make($getNotificationData()),
            UpdateNotification::class => MockResponse::make($getNotificationData()),
        ]);

        $data = NotificationData::fromArray(data: $getNotificationData());

        expect(value: Notification::create(data: $data))->toBeInstanceOf(class: NotificationData::class)
            ->and(value: Notification::update(data: $data))->toBeInstanceOf(class: NotificationData::class);
    });

    test(description: 'propagates errors', closure: function () use ($getNotificationData) {
        MockClient::global(mockData: [
            CreateNotification::class => MockResponse::make(body: [], status: 400),
            UpdateNotification::class => MockResponse::make(body: [], status: 500),
        ]);

        $data = NotificationData::fromArray(data: $getNotificationData());

        expect(value: fn () => Notification::create(data: $data))->toThrow(exception: RequestException::class)
            ->and(value: fn () => Notification::update(data: $data))->toThrow(exception: RequestException::class);
    });
});

describe(description: 'delete, types and notificators', tests: function () {
    test(description: 'delete request resolves the correct endpoint', closure: function () {
        $request = new DeleteNotification(id: 41);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/notifications/41')
            ->and(value: $request->getMethod())->toBe(expected: Method::DELETE);
    });

    test(description: 'types request resolves the correct endpoint', closure: function () {
        $request = new GetNotificationTypes();

        expect(value: $request->resolveEndpoint())->toBe(expected: '/notifications/types')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET);
    });

    test(description: 'notificators request resolves the correct endpoint', closure: function () {
        $request = new GetNotificators(announcement: true);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/notifications/notificators')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET)
            ->and(value: $request->query()->all())->toBe(expected: ['announcement' => true]);
    });

    test(description: 'deletes a notification and returns types/notificators', closure: function () {
        MockClient::global(mockData: [
            DeleteNotification::class   => MockResponse::make(body: '', status: 204),
            GetNotificationTypes::class => MockResponse::make([['type' => 'ignitionOn']]),
            GetNotificators::class      => MockResponse::make([['type' => 'mail']]),
        ]);

        expect(value: Notification::delete(id: 41))->toBeInstanceOf(class: StatusData::class)
            ->and(value: Notification::types()->first())->toBeInstanceOf(class: NotificationTypeData::class)
            ->and(value: Notification::notificators()->first())->toBeInstanceOf(class: NotificationTypeData::class);
    });

    test(description: 'propagates delete error', closure: function () {
        MockClient::global(mockData: [
            DeleteNotification::class => MockResponse::make(body: [], status: 404),
        ]);

        expect(value: fn () => Notification::delete(id: 41))->toThrow(exception: RequestException::class);
    });

    test(description: 'propagates types error', closure: function () {
        MockClient::global(mockData: [
            GetNotificationTypes::class => MockResponse::make(body: [], status: 500),
        ]);

        expect(value: fn () => Notification::types())->toThrow(exception: RequestException::class);
    });
});

describe(description: 'send', tests: function () {
    test(description: 'send test request resolves the correct endpoint', closure: function () {
        $request = new SendTestNotification();

        expect(value: $request->resolveEndpoint())->toBe(expected: '/notifications/test')
            ->and(value: $request->getMethod())->toBe(expected: Method::POST);

        $requestWithNotificator = new SendTestNotification(notificator: 'mail');

        expect(value: $requestWithNotificator->resolveEndpoint())->toBe(expected: '/notifications/test/mail')
            ->and(value: $requestWithNotificator->getMethod())->toBe(expected: Method::POST);
    });

    test(description: 'send notification request serializes query and body', closure: function () {
        $message = new NotificationMessageData(body: 'Hello team', subject: 'Alert', digest: 'Short', priority: true);
        $request = new SendNotification(notificator: 'mail', message: $message, userIds: [1, 2]);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/notifications/send/mail')
            ->and(value: $request->getMethod())->toBe(expected: Method::POST)
            ->and(value: $request->query()->all())->toBe(expected: ['userId' => [1, 2]])
            ->and(value: $request->body()->all())->toBe(expected: $message->toArray());
    });

    test(description: 'sends test and custom notifications', closure: function () {
        MockClient::global(mockData: [
            SendTestNotification::class => MockResponse::make(body: '', status: 204),
            SendNotification::class     => MockResponse::make(body: '', status: 204),
        ]);

        $message = new NotificationMessageData(body: 'Hello team');

        expect(value: Notification::sendTest())->toBeInstanceOf(class: StatusData::class)
            ->and(value: Notification::send(notificator: 'mail', message: $message, userIds: [1, 2]))->toBeInstanceOf(class: StatusData::class)
            ->and(value: Notification::sendTest()->status)->toBe(expected: Status::SUCCESS);
    });

    test(description: 'propagates errors', closure: function () {
        MockClient::global(mockData: [
            SendTestNotification::class => MockResponse::make(body: [], status: 400),
            SendNotification::class     => MockResponse::make(body: [], status: 500),
        ]);

        $message = new NotificationMessageData(body: 'Hello team');

        expect(value: fn () => Notification::sendTest())->toThrow(exception: RequestException::class)
            ->and(value: fn () => Notification::send(notificator: 'mail', message: $message, userIds: [1, 2]))->toThrow(exception: RequestException::class);
    });
});
