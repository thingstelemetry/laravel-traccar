<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection all(?bool $all = null, ?int $userId = null, ?int $deviceId = null, ?int $groupId = null, ?bool $refresh = null, ?int $limit = null, ?int $offset = null, ?string $keyword = null)
 * @method static \ThingsTelemetry\Traccar\Dto\NotificationData create(\ThingsTelemetry\Traccar\Dto\NotificationData $data)
 * @method static \ThingsTelemetry\Traccar\Dto\NotificationData update(\ThingsTelemetry\Traccar\Dto\NotificationData $data)
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData delete(int $id)
 * @method static \Illuminate\Support\Collection types()
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData sendTest()
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData send(string $notificator, \ThingsTelemetry\Traccar\Dto\NotificationMessageData $message, ?array $userIds = null)
 *
 * @see \ThingsTelemetry\Traccar\Endpoints\Notification
 */
class Notification extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Notification::class;
    }
}
