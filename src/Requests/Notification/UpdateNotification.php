<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Notification;

use Saloon\Http\Response;
use InvalidArgumentException;
use ThingsTelemetry\Traccar\Dto\NotificationData;
use ThingsTelemetry\Traccar\Requests\Abstract\UpdateRequest;

class UpdateNotification extends UpdateRequest
{
    public function __construct(public NotificationData $data)
    {
        if (is_null($data->id)) {
            throw new InvalidArgumentException(message: 'Notification ID is required for update operations.');
        }
    }

    public function resolveEndpoint(): string
    {
        return "/notifications/{$this->data->id}";
    }

    public function createDtoFromResponse(Response $response): NotificationData
    {
        return NotificationData::fromArray(data: $response->json());
    }
}
