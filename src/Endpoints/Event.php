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
     * @deprecated Use get(int $id) instead. Will be removed in the next major version.
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function find(int $id): EventData
    {
        trigger_error(message: 'Event::find() is deprecated. Use Event::get() instead.', error_level: E_USER_DEPRECATED);

        return $this->get(id: $id);
    }
}
