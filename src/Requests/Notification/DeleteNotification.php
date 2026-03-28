<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Notification;

use ThingsTelemetry\Traccar\Requests\Abstract\DeleteByIdRequest;

class DeleteNotification extends DeleteByIdRequest
{
    public function resolveEndpoint(): string
    {
        return "/notifications/{$this->id}";
    }
}
