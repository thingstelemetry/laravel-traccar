<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Maintenance;

use ThingsTelemetry\Traccar\Requests\Abstract\DeleteByIdRequest;

class DeleteMaintenance extends DeleteByIdRequest
{
    public function resolveEndpoint(): string
    {
        return "/maintenance/{$this->id}";
    }
}
