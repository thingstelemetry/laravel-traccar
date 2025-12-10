<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Requests\DeletePosition;

class Position extends Traccar
{
    /**
     * Delete a position by ID.
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function delete(int $id): StatusData
    {
        $response = $this->connector->send(request: new DeletePosition(id: $id));

        return $response->dtoOrFail();
    }
}
