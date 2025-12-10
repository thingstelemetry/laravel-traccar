<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use Carbon\CarbonInterface;
use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Dto\StatusData;
use Illuminate\Validation\ValidationException;
use ThingsTelemetry\Traccar\Requests\DeletePosition;
use ThingsTelemetry\Traccar\Requests\DeleteDevicePositions;

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

    /**
     * Delete all positions for a device within the given time range.
     *
     * @throws \Saloon\Exceptions\SaloonException
     * @throws ValidationException
     */
    public function deleteForDeviceInRange(int $deviceId, CarbonInterface $from, CarbonInterface $to): StatusData
    {
        if ($from->greaterThanOrEqualTo($to)) {
            throw ValidationException::withMessages([
                'from' => ['The from timestamp must be before the to timestamp.'],
            ]);
        }

        $response = $this->connector->send(
            request: new DeleteDevicePositions(
                deviceId: $deviceId,
                from: $from,
                to: $to,
            )
        );

        return $response->dtoOrFail();
    }
}
