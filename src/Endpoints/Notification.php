<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Dto\NotificationData;
use ThingsTelemetry\Traccar\Dto\NotificationTypeData;
use ThingsTelemetry\Traccar\Dto\NotificationMessageData;
use ThingsTelemetry\Traccar\Requests\Notification\SendNotification;
use ThingsTelemetry\Traccar\Requests\Notification\CreateNotification;
use ThingsTelemetry\Traccar\Requests\Notification\DeleteNotification;
use ThingsTelemetry\Traccar\Requests\Notification\UpdateNotification;
use ThingsTelemetry\Traccar\Requests\Notification\GetAllNotifications;
use ThingsTelemetry\Traccar\Requests\Notification\GetNotificationTypes;
use ThingsTelemetry\Traccar\Requests\Notification\SendTestNotification;

class Notification extends Traccar
{
    /** @throws \Saloon\Exceptions\SaloonException */
    public function all(?bool $all = null, ?int $userId = null, ?int $deviceId = null, ?int $groupId = null, ?bool $refresh = null, ?int $limit = null, ?int $offset = null, ?string $keyword = null): Collection
    {
        return $this->connector->send(
            request: new GetAllNotifications(
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
    public function create(NotificationData $data): NotificationData
    {
        return $this->connector->send(request: new CreateNotification(data: $data))->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function update(NotificationData $data): NotificationData
    {
        return $this->connector->send(request: new UpdateNotification(data: $data))->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function delete(int $id): StatusData
    {
        return $this->connector->send(request: new DeleteNotification(id: $id))->dtoOrFail();
    }

    /**
     * @return Collection<int, NotificationTypeData>
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function types(): Collection
    {
        return $this->connector->send(request: new GetNotificationTypes())->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function sendTest(): StatusData
    {
        return $this->connector->send(request: new SendTestNotification())->dtoOrFail();
    }

    /**
     * @param  array<int>|null  $userIds
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function send(string $notificator, NotificationMessageData $message, ?array $userIds = null): StatusData
    {
        return $this->connector->send(
            request: new SendNotification(
                notificator: $notificator,
                message: $message,
                userIds: $userIds,
            )
        )->dtoOrFail();
    }
}
