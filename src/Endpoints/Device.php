<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Endpoints;

use Illuminate\Support\Collection;
use TrackTelemetry\Traccar\Traccar;
use TrackTelemetry\Traccar\Enums\Status;
use TrackTelemetry\Traccar\Dto\DeviceData;
use TrackTelemetry\Traccar\Requests\CreateDevice;
use TrackTelemetry\Traccar\Requests\DeleteDevice;
use TrackTelemetry\Traccar\Requests\UpdateDevice;
use TrackTelemetry\Traccar\Requests\GetAllDevices;
use TrackTelemetry\Traccar\Requests\GetForUserDevices;
use TrackTelemetry\Traccar\Requests\UpdateDeviceTotals;

class Device extends Traccar
{
    /**
     * Get all devices
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function getAll(): Collection
    {
        $response = $this->connector->send(request: new GetAllDevices());

        return $response->dtoOrFail();
    }

    /**
     * Get devices by id, unique id or user id
     * or returns a list of the user's devices
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function get(?int $userId = null, ?array $ids = null, ?array $uniqueIds = null): Collection
    {
        $response = $this->connector->send(
            request: new GetForUserDevices(
                userId: $userId,
                ids: $ids,
                uniqueIds: $uniqueIds
            )
        );

        return $response->dtoOrFail();
    }

    /**
     * Create a new device.
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function create(DeviceData $data): DeviceData
    {
        $response = $this->connector->send(request: new CreateDevice(data: $data));

        return $response->dtoOrFail();
    }

    /**
     * Update an existing device.
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function update(DeviceData $data): DeviceData
    {
        $response = $this->connector->send(request: new UpdateDevice(data: $data));

        return $response->dtoOrFail();
    }

    /**
     * Update total distance and hours of the Device.
     *
     * Note: The path parameter `id` must equal the body `deviceId`.
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function updateTotals(int $deviceId, float $totalDistance, float $hours): Status
    {
        $response = $this->connector->send(
            request: new UpdateDeviceTotals(
                deviceId: $deviceId,
                totalDistance: $totalDistance,
                hours: $hours,
            )
        );

        return $response->dtoOrFail();
    }

    /**
     * Delete a device by ID.
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function delete(int $id): Status
    {
        $response = $this->connector->send(request: new DeleteDevice(id: $id));

        return $response->dtoOrFail();
    }
}
