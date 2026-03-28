<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Command;

use ThingsTelemetry\Traccar\Requests\Abstract\DeleteByIdRequest;

class DeleteCommand extends DeleteByIdRequest
{
    public function resolveEndpoint(): string
    {
        return "/commands/{$this->id}";
    }
}
