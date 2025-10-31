<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Endpoints;

use TrackTelemetry\Traccar\Traccar;
use TrackTelemetry\Traccar\Dto\EventData;
use TrackTelemetry\Traccar\Requests\GetEvent;

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
