<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Dto\CommandData;
use ThingsTelemetry\Traccar\Dto\CommandTypeData;
use ThingsTelemetry\Traccar\Requests\Command\SendCommand;
use ThingsTelemetry\Traccar\Dto\CommandDispatchResultData;
use ThingsTelemetry\Traccar\Requests\Command\CreateCommand;
use ThingsTelemetry\Traccar\Requests\Command\DeleteCommand;
use ThingsTelemetry\Traccar\Requests\Command\UpdateCommand;
use ThingsTelemetry\Traccar\Requests\Command\GetAllCommands;
use ThingsTelemetry\Traccar\Requests\Command\GetCommandTypes;
use ThingsTelemetry\Traccar\Requests\Command\GetSendableCommands;

class Command extends Traccar
{
    /** @throws \Saloon\Exceptions\SaloonException */
    public function getAll(?bool $all = null, ?int $userId = null, ?int $deviceId = null, ?int $groupId = null, ?bool $refresh = null, ?int $limit = null, ?int $offset = null, ?string $keyword = null): Collection
    {
        return $this->connector->send(
            request: new GetAllCommands(
                all: $all,
                userId: $userId,
                deviceId: $deviceId,
                groupId: $groupId,
                refresh: $refresh,
                limit: $limit,
                offset: $offset,
                keyword: $keyword,
            )
        )->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function create(CommandData $data): CommandData
    {
        return $this->connector->send(request: new CreateCommand(data: $data))->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function update(CommandData $data): CommandData
    {
        return $this->connector->send(request: new UpdateCommand(data: $data))->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function delete(int $id): StatusData
    {
        return $this->connector->send(request: new DeleteCommand(id: $id))->dtoOrFail();
    }

    /** @return Collection<int, CommandData> @throws \Saloon\Exceptions\SaloonException */
    public function getSendableForDevice(int $deviceId): Collection
    {
        return $this->connector->send(request: new GetSendableCommands(deviceId: $deviceId))->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function send(CommandData $data, ?int $groupId = null): CommandDispatchResultData
    {
        return $this->connector->send(request: new SendCommand(data: $data, groupId: $groupId))->dtoOrFail();
    }

    /**
     * @return Collection<int, CommandTypeData>
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function types(?int $deviceId = null, ?bool $textChannel = null): Collection
    {
        return $this->connector->send(
            request: new GetCommandTypes(deviceId: $deviceId, textChannel: $textChannel)
        )->dtoOrFail();
    }
}
