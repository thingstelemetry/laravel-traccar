<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\User;

use ThingsTelemetry\Traccar\Requests\Abstract\DeleteByIdRequest;

class DeleteUser extends DeleteByIdRequest
{
    public function resolveEndpoint(): string
    {
        return "/users/{$this->id}";
    }
}
