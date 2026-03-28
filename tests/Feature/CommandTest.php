<?php

declare(strict_types=1);

use Saloon\Enums\Method;
use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Dto\CommandData;
use ThingsTelemetry\Traccar\Facades\Command;
use Saloon\Exceptions\Request\RequestException;
use ThingsTelemetry\Traccar\Dto\CommandTypeData;
use ThingsTelemetry\Traccar\Dto\QueuedCommandData;
use ThingsTelemetry\Traccar\Requests\Command\SendCommand;
use ThingsTelemetry\Traccar\Dto\CommandDispatchResultData;
use ThingsTelemetry\Traccar\Requests\Command\CreateCommand;
use ThingsTelemetry\Traccar\Requests\Command\DeleteCommand;
use ThingsTelemetry\Traccar\Requests\Command\UpdateCommand;
use ThingsTelemetry\Traccar\Requests\Command\GetAllCommands;
use ThingsTelemetry\Traccar\Requests\Command\GetCommandTypes;
use ThingsTelemetry\Traccar\Requests\Command\GetSendableCommands;

$getCommandData = fn () => [
    'id'          => 21,
    'deviceId'    => 6,
    'description' => 'Engine Stop',
    'type'        => 'engineStop',
    'textChannel' => false,
    'attributes'  => ['data' => 'OFF'],
];

$getQueuedCommandData = fn () => [
    'id'          => 31,
    'deviceId'    => 6,
    'type'        => 'engineStop',
    'textChannel' => false,
    'attributes'  => ['data' => 'OFF'],
];

describe(description: 'all', tests: function () use ($getCommandData) {
    test(description: 'request sends the correct query parameters', closure: function () {
        $request = new GetAllCommands(all: true, userId: 1, deviceId: 6, groupId: 7, refresh: true, limit: 10, offset: 2, keyword: 'engine');

        expect(value: $request->resolveEndpoint())->toBe(expected: '/commands')
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

    test(description: 'returns all commands', closure: function () use ($getCommandData) {
        MockClient::global(mockData: [
            GetAllCommands::class => MockResponse::make([$getCommandData()]),
        ]);

        $response = Command::all();

        expect(value: $response)
            ->toBeInstanceOf(class: Collection::class)
            ->and(value: $response->first())->toBeInstanceOf(class: CommandData::class);
    });

    test(description: 'propagates errors', closure: function () {
        MockClient::global(mockData: [
            GetAllCommands::class => MockResponse::make(body: [], status: 500),
        ]);

        expect(value: fn () => Command::all())->toThrow(exception: RequestException::class);
    });
});

describe(description: 'create and update', tests: function () use ($getCommandData) {
    test(description: 'create request sends the correct body', closure: function () use ($getCommandData) {
        $data = CommandData::fromArray(data: $getCommandData());
        $request = new CreateCommand(data: $data);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/commands')
            ->and(value: $request->getMethod())->toBe(expected: Method::POST)
            ->and(value: $request->body()->all())->toBe(expected: $data->toArray());
    });

    test(description: 'update request sends the correct body', closure: function () use ($getCommandData) {
        $data = CommandData::fromArray(data: $getCommandData());
        $request = new UpdateCommand(data: $data);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/commands/21')
            ->and(value: $request->getMethod())->toBe(expected: Method::PUT)
            ->and(value: $request->body()->all())->toBe(expected: $data->toArray());
    });

    test(description: 'creates and updates a command', closure: function () use ($getCommandData) {
        MockClient::global(mockData: [
            CreateCommand::class => MockResponse::make($getCommandData()),
            UpdateCommand::class => MockResponse::make($getCommandData()),
        ]);

        $data = CommandData::fromArray(data: $getCommandData());

        expect(value: Command::create(data: $data))->toBeInstanceOf(class: CommandData::class)
            ->and(value: Command::update(data: $data))->toBeInstanceOf(class: CommandData::class);
    });

    test(description: 'propagates errors', closure: function () use ($getCommandData) {
        MockClient::global(mockData: [
            CreateCommand::class => MockResponse::make(body: [], status: 400),
            UpdateCommand::class => MockResponse::make(body: [], status: 500),
        ]);

        $data = CommandData::fromArray(data: $getCommandData());

        expect(value: fn () => Command::create(data: $data))->toThrow(exception: RequestException::class)
            ->and(value: fn () => Command::update(data: $data))->toThrow(exception: RequestException::class);
    });
});

describe(description: 'delete', tests: function () {
    test(description: 'request resolves the correct endpoint', closure: function () {
        $request = new DeleteCommand(id: 21);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/commands/21')
            ->and(value: $request->getMethod())->toBe(expected: Method::DELETE);
    });

    test(description: 'deletes a command', closure: function () {
        MockClient::global(mockData: [
            DeleteCommand::class => MockResponse::make(body: '', status: 204),
        ]);

        $result = Command::delete(id: 21);

        expect(value: $result)
            ->toBeInstanceOf(class: StatusData::class)
            ->and(value: $result->status)->toBe(expected: Status::SUCCESS);
    });

    test(description: 'propagates errors', closure: function () {
        MockClient::global(mockData: [
            DeleteCommand::class => MockResponse::make(body: [], status: 404),
        ]);

        expect(value: fn () => Command::delete(id: 21))->toThrow(exception: RequestException::class);
    });
});

describe(description: 'sendable and types', tests: function () use ($getCommandData) {
    test(description: 'sendable request sends the correct query parameters', closure: function () {
        $request = new GetSendableCommands(deviceId: 6);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/commands/send')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET)
            ->and(value: $request->query()->all())->toBe(expected: ['deviceId' => 6]);
    });

    test(description: 'types request sends the correct query parameters', closure: function () {
        $request = new GetCommandTypes(deviceId: 6, textChannel: true);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/commands/types')
            ->and(value: $request->getMethod())->toBe(expected: Method::GET)
            ->and(value: $request->query()->all())->toBe(expected: [
                'deviceId'    => 6,
                'textChannel' => true,
            ]);
    });

    test(description: 'returns sendable commands and types', closure: function () use ($getCommandData) {
        MockClient::global(mockData: [
            GetSendableCommands::class => MockResponse::make([$getCommandData()]),
            GetCommandTypes::class     => MockResponse::make([['type' => 'engineStop']]),
        ]);

        expect(value: Command::getSendableForDevice(deviceId: 6)->first())->toBeInstanceOf(class: CommandData::class)
            ->and(value: Command::types()->first())->toBeInstanceOf(class: CommandTypeData::class);
    });

    test(description: 'propagates errors', closure: function () {
        MockClient::global(mockData: [
            GetSendableCommands::class => MockResponse::make(body: [], status: 500),
            GetCommandTypes::class     => MockResponse::make(body: [], status: 500),
        ]);

        expect(value: fn () => Command::getSendableForDevice(deviceId: 6))->toThrow(exception: RequestException::class)
            ->and(value: fn () => Command::types())->toThrow(exception: RequestException::class);
    });
});

describe(description: 'send', tests: function () use ($getCommandData, $getQueuedCommandData) {
    test(description: 'request sends the correct body and query parameters', closure: function () use ($getCommandData) {
        $data = CommandData::fromArray(data: $getCommandData());
        $request = new SendCommand(data: $data, groupId: 7);

        expect(value: $request->resolveEndpoint())->toBe(expected: '/commands/send')
            ->and(value: $request->getMethod())->toBe(expected: Method::POST)
            ->and(value: $request->query()->all())->toBe(expected: ['groupId' => 7])
            ->and(value: $request->body()->all())->toBe(expected: $data->toArray());
    });

    test(description: 'normalizes an immediate command response', closure: function () use ($getCommandData) {
        MockClient::global(mockData: [
            SendCommand::class => MockResponse::make($getCommandData()),
        ]);

        $result = Command::send(data: CommandData::fromArray(data: $getCommandData()));

        expect(value: $result)
            ->toBeInstanceOf(class: CommandDispatchResultData::class)
            ->and(value: $result->sentCommand)->toBeInstanceOf(class: CommandData::class)
            ->and(value: $result->queuedCommands)->toHaveCount(count: 0);
    });

    test(description: 'normalizes single queued command response', closure: function () use ($getCommandData, $getQueuedCommandData) {
        MockClient::global(mockData: [
            SendCommand::class => MockResponse::make($getQueuedCommandData()),
        ]);

        $result = Command::send(data: CommandData::fromArray(data: $getCommandData()));

        expect(value: $result->sentCommand)->toBeNull()
            ->and(value: $result->queuedCommands->first())->toBeInstanceOf(class: QueuedCommandData::class)
            ->and(value: $result->queuedCommands)->toHaveCount(count: 1);
    });

    test(description: 'normalizes multiple queued command responses', closure: function () use ($getCommandData, $getQueuedCommandData) {
        MockClient::global(mockData: [
            SendCommand::class => MockResponse::make([$getQueuedCommandData(), $getQueuedCommandData()]),
        ]);

        $result = Command::send(data: CommandData::fromArray(data: $getCommandData()));

        expect(value: $result->sentCommand)->toBeNull()
            ->and(value: $result->queuedCommands->first())->toBeInstanceOf(class: QueuedCommandData::class)
            ->and(value: $result->queuedCommands)->toHaveCount(count: 2);
    });

    test(description: 'propagates errors', closure: function () use ($getCommandData) {
        MockClient::global(mockData: [
            SendCommand::class => MockResponse::make(body: [], status: 500),
        ]);

        expect(value: fn () => Command::send(data: CommandData::fromArray(data: $getCommandData())))->toThrow(exception: RequestException::class);
    });
});
