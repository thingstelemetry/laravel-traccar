<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Position;

use ThingsTelemetry\Traccar\Requests\Abstract\DeleteByIdRequest;

class DeletePosition extends DeleteByIdRequest
{
    public function resolveEndpoint(): string
    {
        return "/positions/{$this->id}";
    }
}
