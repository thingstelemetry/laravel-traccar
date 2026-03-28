<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Notification;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\NotificationTypeData;

class GetNotificationTypes extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/notifications/types';
    }

    /** @return Collection<int, NotificationTypeData> */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect(value: $response->json())
            ->map(callback: fn (array $type) => NotificationTypeData::fromArray(data: $type));
    }
}
