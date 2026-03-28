<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Notification;

use Saloon\Http\Response;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\NotificationData;
use ThingsTelemetry\Traccar\Requests\Abstract\GetAllRequest;

class GetAllNotifications extends GetAllRequest
{
    public function resolveEndpoint(): string
    {
        return '/notifications';
    }

    /** @return Collection<int, NotificationData> */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect(value: $response->json())
            ->map(callback: fn (array $notification) => NotificationData::fromArray(data: $notification));
    }
}
