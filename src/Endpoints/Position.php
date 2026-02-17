<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use Carbon\CarbonInterface;
use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Dto\StatusData;
use Illuminate\Validation\ValidationException;
use ThingsTelemetry\Traccar\Requests\Position\DeletePosition;
use ThingsTelemetry\Traccar\Requests\Position\DeleteDevicePositions;

class Position extends Traccar
{
    /** @throws \Saloon\Exceptions\SaloonException */
    public function delete(int $id): StatusData
    {
        $response = $this->connector->send(request: new DeletePosition(id: $id));

        return $response->dtoOrFail();
    }

    /**
     * @throws \Saloon\Exceptions\SaloonException
     * @throws \Illuminate\Validation\ValidationException
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
