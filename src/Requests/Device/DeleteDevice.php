<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Device;

use ThingsTelemetry\Traccar\Requests\Abstract\DeleteByIdRequest;

class DeleteDevice extends DeleteByIdRequest
{
    public function resolveEndpoint(): string
    {
        return "/devices/{$this->id}";
    }
}
