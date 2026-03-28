<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Group;

use ThingsTelemetry\Traccar\Requests\Abstract\DeleteByIdRequest;

class DeleteGroup extends DeleteByIdRequest
{
    public function resolveEndpoint(): string
    {
        return "/groups/{$this->id}";
    }
}
