<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Driver;

use ThingsTelemetry\Traccar\Requests\Abstract\DeleteByIdRequest;

class DeleteDriver extends DeleteByIdRequest
{
    public function resolveEndpoint(): string
    {
        return "/drivers/{$this->id}";
    }
}
