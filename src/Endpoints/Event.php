<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Dto\EventData;
use ThingsTelemetry\Traccar\Requests\GetEvent;

class Event extends Traccar
{
    /**
     * Retrieve an event by ID.
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function get(int $id): EventData
    {
        $response = $this->connector->send(request: new GetEvent(id: $id));

        return $response->dtoOrFail();
    }
}
