<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Order;

use ThingsTelemetry\Traccar\Requests\Abstract\DeleteByIdRequest;

class DeleteOrder extends DeleteByIdRequest
{
    public function resolveEndpoint(): string
    {
        return "/orders/{$this->id}";
    }
}
