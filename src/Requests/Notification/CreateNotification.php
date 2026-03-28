<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Notification;

use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Dto\NotificationData;
use ThingsTelemetry\Traccar\Requests\Abstract\CreateRequest;

class CreateNotification extends CreateRequest
{
    public function __construct(public NotificationData $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/notifications';
    }

    public function createDtoFromResponse(Response $response): NotificationData
    {
        return NotificationData::fromArray(data: $response->json());
    }
}
