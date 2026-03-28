<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Dto\EventData;
use ThingsTelemetry\Traccar\Requests\Event\GetEvent;

class Event extends Traccar
{
    /** @throws \Saloon\Exceptions\SaloonException */
    public function get(int $id): EventData
    {
        $response = $this->connector->send(request: new GetEvent(id: $id));

        return $response->dtoOrFail();
    }

    /**
     * @deprecated Use get() instead. Will be removed in the next major version.
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function find(int $id): EventData
    {
        return $this->get(id: $id);
    }
}
