<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Requests\Health\GetHealth;

class Health extends Traccar
{
    /** @throws \Saloon\Exceptions\SaloonException */
    public function check(): string
    {
        return $this->connector->send(request: new GetHealth())->dtoOrFail();
    }
}
