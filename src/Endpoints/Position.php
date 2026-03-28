<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Dto\PositionData;
use Illuminate\Validation\ValidationException;
use ThingsTelemetry\Traccar\Requests\Position\GetPositions;
use ThingsTelemetry\Traccar\Requests\Position\DeletePosition;
use ThingsTelemetry\Traccar\Requests\Position\GetPositionsCsv;
use ThingsTelemetry\Traccar\Requests\Position\GetPositionsGpx;
use ThingsTelemetry\Traccar\Requests\Position\GetPositionsKml;
use ThingsTelemetry\Traccar\Requests\Position\DeleteDevicePositions;

class Position extends Traccar
{
    /**
     * @param  array<int>|null  $ids
     * @return Collection<int, PositionData>
     *
     * @throws \Saloon\Exceptions\SaloonException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function all(
        ?int $deviceId = null,
        ?CarbonInterface $from = null,
        ?CarbonInterface $to = null,
        ?int $geofenceId = null,
        ?array $ids = null,
    ): Collection {
        $this->guardOptionalRange(from: $from, to: $to);

        if ($deviceId !== null) {
            $this->guardRequiredRange(from: $from, to: $to);
        }

        $response = $this->connector->send(
            request: new GetPositions(
                deviceId: $deviceId,
                from: $from,
                to: $to,
                geofenceId: $geofenceId,
                ids: $ids,
            )
        );

        return $response->dtoOrFail();
    }

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
    public function exportKml(int $deviceId, CarbonInterface $from, CarbonInterface $to): string
    {
        $this->guardRequiredRange(from: $from, to: $to);

        $response = $this->connector->send(
            request: new GetPositionsKml(
                deviceId: $deviceId,
                from: $from,
                to: $to,
            )
        );

        return $response->dtoOrFail();
    }

    /**
     * @throws \Saloon\Exceptions\SaloonException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function exportCsv(int $deviceId, CarbonInterface $from, CarbonInterface $to, ?int $geofenceId = null): string
    {
        $this->guardRequiredRange(from: $from, to: $to);

        $response = $this->connector->send(
            request: new GetPositionsCsv(
                deviceId: $deviceId,
                from: $from,
                to: $to,
                geofenceId: $geofenceId,
            )
        );

        return $response->dtoOrFail();
    }

    /**
     * @throws \Saloon\Exceptions\SaloonException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function exportGpx(int $deviceId, CarbonInterface $from, CarbonInterface $to): string
    {
        $this->guardRequiredRange(from: $from, to: $to);

        $response = $this->connector->send(
            request: new GetPositionsGpx(
                deviceId: $deviceId,
                from: $from,
                to: $to,
            )
        );

        return $response->dtoOrFail();
    }

    /**
     * @throws \Saloon\Exceptions\SaloonException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function deleteForDeviceInRange(int $deviceId, CarbonInterface $from, CarbonInterface $to): StatusData
    {
        $this->guardRequiredRange(from: $from, to: $to);

        $response = $this->connector->send(
            request: new DeleteDevicePositions(
                deviceId: $deviceId,
                from: $from,
                to: $to,
            )
        );

        return $response->dtoOrFail();
    }

    /** @throws ValidationException */
    private function guardRequiredRange(?CarbonInterface $from, ?CarbonInterface $to): void
    {
        if ($from === null || $to === null) {
            throw ValidationException::withMessages([
                'from' => ['Both from and to timestamps are required.'],
            ]);
        }

        if ($from->greaterThanOrEqualTo($to)) {
            throw ValidationException::withMessages([
                'from' => ['The from timestamp must be before the to timestamp.'],
            ]);
        }
    }

    /** @throws ValidationException */
    private function guardOptionalRange(?CarbonInterface $from, ?CarbonInterface $to): void
    {
        if (($from === null) === ($to === null)) {
            if ($from !== null && $to !== null && $from->greaterThanOrEqualTo($to)) {
                throw ValidationException::withMessages([
                    'from' => ['The from timestamp must be before the to timestamp.'],
                ]);
            }

            return;
        }

        throw ValidationException::withMessages([
            'from' => ['Both from and to timestamps must be provided together.'],
        ]);
    }
}
