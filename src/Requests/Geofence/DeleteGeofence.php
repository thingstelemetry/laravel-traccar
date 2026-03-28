<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Geofence;

use ThingsTelemetry\Traccar\Requests\Abstract\DeleteByIdRequest;

class DeleteGeofence extends DeleteByIdRequest
{
    public function resolveEndpoint(): string
    {
        return "/geofences/{$this->id}";
    }
}
